/*! PhotoSwipe plugin - v4.1.2 - 2017-04-05
* http://photoswipe.com
* Copyright (c) 2017 Dmitry Semenov; */
$.initPhotoSwipeFromDOM = function(gallerySelector,medDom) {
    var parseThumbnailElements = function(el) {
        var thumbElements = $(medDom,el),
            numNodes = thumbElements.length,
            items = [],
            el,
            childElements,
            thumbnailEl,
            size,
            item;
        for (var i = 0; i < numNodes; i++) {
            el = thumbElements[i];
            // include only element nodes
            if (el.nodeType !== 1) {
                continue;
            }
            childElements = el.children;
            size = el.getAttribute('data-size').split('x');
            // create slide object
            item = {
                src: el.getAttribute('href'),
                w: parseInt(size[0], 10),
                h: parseInt(size[1], 10),
                author: el.getAttribute('data-author')
            };
            item.el = el; // save link to element for getThumbBoundsFn
            if (childElements.length > 0) {
                item.msrc = childElements[0].getAttribute('src'); // thumbnail url
                if (childElements.length > 1) {
                    item.title = childElements[1].innerHTML/*childElements[0].getAttribute('alt')*/; // caption (contents of figure)
                }
            }
            var mediumSrc = el.getAttribute('data-med');
            if (mediumSrc) {
                size = el.getAttribute('data-med-size').split('x');
                // "medium-sized" image
                item.m = {
                    src: mediumSrc,
                    w: parseInt(size[0], 10),
                    h: parseInt(size[1], 10)
                };
            }
            // original image
            item.o = {
                src: item.src,
                w: item.w,
                h: item.h
            };
            items.push(item);
        }
        return items;
    };
    // find nearest parent element
    var closest = function closest(el, fn) {
        return el && (fn(el) ? el : closest(el.parentNode, fn));
    };
    var onThumbnailsClick = function(e,parents) {
        e = e || window.event;
        if($(e.target).closest('a').attr('data-med')) e.preventDefault ? e.preventDefault() : e.returnValue = false;
        var eTarget = e.target || e.srcElement;
        var clickedListItem = closest(eTarget, function(el) {
            return el.tagName === 'A';
        });
        if (!clickedListItem) {
            return;
        }
        var clickedGallery = parents,
            clickedListItemMed=$(clickedListItem).data('med'),
            index;
        $(medDom,parents).each(function(i, el) {
            if($(this).data('med')==clickedListItemMed){
                index=i;
                return false;
            }
        });
        if (index >= 0) {
            openPhotoSwipe(index, clickedGallery);
        }
        return false;
    };
    var photoswipeParseHash = function() {
        var hash = window.location.hash.substring(1),
            params = {};
        if (hash.length < 5) { // pid=1
            return params;
        }
        var vars = hash.split('&');
        for (var i = 0; i < vars.length; i++) {
            if (!vars[i]) {
                continue;
            }
            var pair = vars[i].split('=');
            if (pair.length < 2) {
                continue;
            }
            params[pair[0]] = pair[1];
        }
        if (params.gid) {
            params.gid = parseInt(params.gid, 10);
        }
        return params;
    };
    var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
        if(!$('.pswp').length){
            var pswp_html='<div id="photoswipe-gallery" class="pswp" tabindex="-1" role="dialog" aria-hidden="true">'
                    +'<div class="pswp__bg"></div>'
                    +'<div class="pswp__scroll-wrap">'
                        +'<div class="pswp__container">'
                            +'<div class="pswp__item"></div>'
                            +'<div class="pswp__item"></div>'
                            +'<div class="pswp__item"></div>'
                        +'</div>'
                        +'<div class="pswp__ui pswp__ui--hidden">'
                            +'<div class="pswp__top-bar">'
                                +'<div class="pswp__counter"></div>'
                                +'<button class="pswp__button pswp__button--close" title="退出画廊"></button>'
                                +'<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>'
                                +'<button class="pswp__button pswp__button--zoom" title="放大 / 缩小"></button>'
                                // +'<button class="pswp__button pswp__button--rotate-left" title="逆时针旋转"><i class="icon md-rotate-ccw" aria-hidden="true"></i></button>'
                                // +'<button class="pswp__button pswp__button--rotate-right" title="顺时针旋转"><i class="icon md-rotate-cw" aria-hidden="true"></i></button>'
                                +'<div class="pswp__preloader">'
                                    +'<div class="pswp__preloader__icn">'
                                        +'<div class="pswp__preloader__cut">'
                                            +'<div class="pswp__preloader__donut"></div>'
                                        +'</div>'
                                    +'</div>'
                                +'</div>'
                            +'</div>'
                             +'<div class="pswp__loading-indicator">'
                                +'<div class="pswp__loading-indicator__line"></div>'
                            +'</div>'
                            +'<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>'
                            +'<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>'
                            +'<div class="pswp__caption">'
                                +'<div class="pswp__caption__center"></div>'
                            +'</div>'
                        +'</div>'
                    +'</div>'
                +'</div>';
            $('body').append(pswp_html);
        }
        var pswpElement = document.querySelectorAll('.pswp')[0],
            gallery,
            options,
            items;
        items = parseThumbnailElements(galleryElement);
        // define options (if needed)
        options = {
            galleryUID: galleryElement.getAttribute('data-pswp-uid'),
            getThumbBoundsFn: function(index) {
                // See Options->getThumbBoundsFn section of docs for more info
                var thumbnail = items[index].el.children[0],
                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                    rect = thumbnail.getBoundingClientRect();
                return {
                    x: rect.left,
                    y: rect.top + pageYScroll,
                    w: rect.width
                };
            },
            addCaptionHTMLFn: function(item, captionEl, isFake) {
                if (!item.title) {
                    captionEl.children[0].innerText = '';
                    return false;
                }
                captionEl.children[0].innerHTML = item.title/* + '<br/><small>Photo: ' + item.author + '</small>'*/;
                return true;
            },
            closeOnScroll:false,
            tapToClose:true,
            tapToToggleControls:false,
            fullscreenEl:false,
            // captionEl:false,
            shareEl:false,
            errorMsg:'<div class="pswp__error-msg"><a href="%url%" target="_blank">图片</a> 加载失败</div>'
        };
        if (fromURL) {
            if (options.galleryPIDs) {
                // parse real index when custom PIDs are used
                // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                for (var j = 0; j < items.length; j++) {
                    if (items[j].pid == index) {
                        options.index = j;
                        break;
                    }
                }
            } else {
                options.index = parseInt(index, 10) - 1;
            }
        } else {
            options.index = parseInt(index, 10);
        }
        // exit if index not found
        if (isNaN(options.index)) {
            return;
        }
        if (disableAnimation) {
            options.showAnimationDuration = 0;
        }
        // Pass data to PhotoSwipe and initialize it
        gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
        // see: http://photoswipe.com/documentation/responsive-images.html
        var realViewportWidth,
            useLargeImages = false,
            firstResize = true,
            imageSrcWillChange;
        gallery.listen('beforeResize', function() {
            var dpiRatio = window.devicePixelRatio ? window.devicePixelRatio : 1;
            dpiRatio = Math.min(dpiRatio, 2.5);
            realViewportWidth = gallery.viewportSize.x * dpiRatio;
            if (realViewportWidth >= 1200 || (!gallery.likelyTouchDevice && realViewportWidth > 800) || screen.width > 1200) {
                if (!useLargeImages) {
                    useLargeImages = true;
                    imageSrcWillChange = true;
                }

            } else {
                if (useLargeImages) {
                    useLargeImages = false;
                    imageSrcWillChange = true;
                }
            }
            if (imageSrcWillChange && !firstResize) {
                gallery.invalidateCurrItems();
            }
            if (firstResize) {
                firstResize = false;
            }
            imageSrcWillChange = false;
        });
        gallery.listen('gettingData', function(index, item) {
            if (useLargeImages) {
                item.src = item.o.src;
                item.w = item.o.w;
                item.h = item.o.h;
            } else {
                item.src = item.m.src;
                item.w = item.m.w;
                item.h = item.m.h;
            }
        });
        gallery.init();
    };
    // select all gallery elements
    // var galleryElements = document.querySelectorAll(gallerySelector),
    var galleryElements = $(gallerySelector),
        medDom=medDom||'[data-med]';
    $(gallerySelector).each(function(index, el) {
        $(this).attr({'data-pswp-uid':index + 1}).click(function(e) {
            onThumbnailsClick(e,this);
        });
    });
    // Parse URL and open gallery if it contains #&pid=3&gid=1
    var hashData = photoswipeParseHash();
    if (hashData.pid && hashData.gid) {
        // openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true);
        openPhotoSwipe(hashData.pid, galleryElements.eq(hashData.gid - 1), true, true);
    }
};
if(location.hash.indexOf('#&gid=')>=0 && location.hash.indexOf('&pid=')>=0) window.history.back();