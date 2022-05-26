(function($) {
    $.fn.textSlider = function(settings) {
        settings = $.extend({
            direc: 1,
            fri: 0,
            fris: 0,
            speed: "normal",
            lines: 1,
            qnum: 1,
            offset: 1000
        },
        settings);
        return this.each(function() {
            $.fn.textSlider.scllor($(this), settings)
        }) 
    };
    $.fn.textSlider.scllor = function($this, settings) {
        var li = $(".cxjli", $this);
        var ul = $(".cxjinfo", $this);
        var uls = $(".cxjitem", $this);
        var ulw = uls.width() * -1;
        var ulh = uls.height() * -1;
        var i = -settings.lines;
        var timer = null;
        var shumu = $(uls).size();
        function autoroll() {
            i += settings.lines;
            if (i > shumu - settings.qnum - settings.fris) {
                i = -settings.fris
            }
            slide(i);
            timer = window.setTimeout(autoroll, settings.offset)
        };
        function slide(i) {
            if (settings.direc == 1) {
                ul.css({
                    "width": shumu * -ulw
                });
                ul.animate({
                    left: ulw * i - settings.fri
                },
                settings.speed)
            }
			if (settings.direc == 5) {
                if (shumu % 2 == 1) {
                    shumu = shumu + 1
                };
                ul.css({
                    "width": (shumu * -ulw) / 2
                });
                ul.animate({
                    left: ulw * i / 2
                },
                settings.speed)
            }
            if (settings.direc == 2) {
                ul.animate({
                    top: ulh * i
                },
                settings.speed)
            }
            if (settings.direc == 3) {
                uls.hide();
                uls.eq(i).show()
            }
            if (settings.direc == 4) {
                uls.hide();
                uls.eq(i).fadeIn().show()
            }
            li.eq(i / settings.lines).addClass('visited').siblings().removeClass('visited')
        };
        li.hover(function() {
            if (timer) {
                clearTimeout(timer);
                i = $(this).prevAll().length * settings.lines;
                slide(i)
            }
        },
        function() {
            timer = window.setTimeout(autoroll, settings.offset);
            this.blur();
            return false
        });
        $('.up', $this).click(function() {
            i += settings.lines;
            if (i > shumu - settings.qnum - settings.fris) {
                i = -settings.fris
            }
            slide(i)
        });
        $('.down', $this).click(function() {
            i -= settings.lines;
            if (i < -settings.fris) {
                i = shumu - settings.qnum - settings.fris
            }
            slide(i)
        });
        autoroll()
    }
})(jQuery);