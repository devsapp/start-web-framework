/*
    Cloud Zoom 10 Site License (CZ01-10).
    Version 3.1 rev 1312051822
*/
(function(e) {
	function s(a) {
		var b = a.zoom,
		c = a.Q,
		g = a.R,
		k = a.e,
		f = a.g;
		this.data = a;
		this.U = this.b = null;
		this.za = 0;
		this.zoom = b;
		this.V = !0;
		this.r = this.interval = this.t = this.p = 0;
		var q = this,
		m;
		q.b = e("<div class='" + a.K + "' style='position:absolute;overflow:hidden'></div>");
		var p = e("<img style='-webkit-touch-callout:none;position:absolute;max-width:none' src='" + v(b.T, b.options) + "'/>");
		b.options.variableMagnification && p.bind("mousewheel",
		function(a, b) {
			q.zoom.ia(0.1 * b);
			return ! 1
		});
		q.U = p;
		p.width(q.zoom.e);
		p.height(q.zoom.g);
		d.Ja && q.U.css("-webkit-transform", "perspective(400px)");
		var l = q.b;
		l.append(p);
		var h = e("<div style='position:absolute;'></div>");
		a.caption ? ("html" == b.options.captionType ? m = a.caption: "attr" == b.options.captionType && (m = e("<div class='cloudzoom-caption'>" + a.caption + "</div>")), m.css("display", "block"), h.css({
			width: k
		}), l.append(h), h.append(m), e("body").append(l), this.r = m.outerHeight(), "bottom" == b.options.captionPosition ? h.css("top", f) : (h.css("top", 0), this.za = this.r)) : e("body").append(l);
		l.css({
			opacity: 0,
			width: k,
			height: f + this.r
		});
		this.zoom.C = "auto" === b.options.minMagnification ? Math.max(k / b.a.width(), f / b.a.height()) : b.options.minMagnification;
		this.zoom.B = "auto" === b.options.maxMagnification ? p.width() / b.a.width() : b.options.maxMagnification;
		a = l.height();
		this.V = !1;
		b.options.zoomFlyOut ? (f = b.a.offset(), f.left += b.d / 2, f.top += b.c / 2, l.offset(f), l.width(0), l.height(0), l.animate({
			left: c,
			top: g,
			width: k,
			height: a,
			opacity: 1
		},
		{
			duration: b.options.animationTime,
			complete: function() {
				q.V = !0
			}
		})) : (l.offset({
			left: c,
			top: g
		}), l.width(k), l.height(a), l.animate({
			opacity: 1
		},
		{
			duration: b.options.animationTime,
			complete: function() {
				q.V = !0
			}
		}))
	}
	function x(a, b, c) {
		this.a = a;
		this.ba = a[0];
		this.Ca = c;
		this.va = !0;
		var g = this;
		this.interval = setInterval(function() {
			0 < g.ba.width && 0 < g.ba.height && (clearInterval(g.interval), g.va = !1, g.Ca(a))
		},
		100);
		this.ba.src = b
	}
	function d(a, b) {
	function c() {
			k.update();
			window.Qa(c)
	}
	function g() {
			var c;
			c = "" != b.image ? b.image: "" + a.attr("src");
			k.sa();
			b.lazyLoadZoom ? a.bind("touchstart.preload " + k.options.mouseTriggerEvent + ".preload",
			function() {
				k.O(c, b.zoomImage)
			}) : k.O(c, b.zoomImage)
	}
	var k = this;
		b = e.extend({},e.fn.CloudZoom.defaults, b);
	var f = d.qa(a, e.fn.CloudZoom.attr);
		b = e.extend({},b, f);
		1 > b.easing && (b.easing = 1);
		f = a.parent();
		f.is("a") && "" == b.zoomImage && (b.zoomImage = f.attr("href"), f.removeAttr("href"));
		f = e("<div class='" + b.zoomClass + "'</div>");
		e("body").append(f);
		this.Z = f.width();
		this.Y = f.height();
		b.zoomWidth && (this.Z = b.zoomWidth, this.Y = b.zoomHeight);
		f.remove();
		this.options = b;
		this.a = a;
		this.g = this.e = this.d = this.c = 0;
		this.H = this.m = null;
		this.j = this.n = 0;
		this.D = {
			x: 0,
			y: 0
		};
		this.Ua = this.caption = "";
		this.ea = {
			x: 0,
			y: 0
		};
		this.k = [];
		this.pa = 0;
		this.oa = "";
		this.b = this.v = this.u = null;
		this.T = "";
		this.L = this.S = this.aa = !1;
		this.G = null;
		this.ha = this.Oa = !1;
		this.l = null;
		this.id = ++d.id;
		this.I = this.ua = this.ta = 0;
		this.o = this.h = null;
		this.wa = this.B = this.C = this.f = this.i = this.ja = 0;
		this.na(a);
		this.ma = !1;
		this.N = this.A = this.da = this.ca = 0;
		if (a.is(":hidden")) var q = setInterval(function() {
			a.is(":hidden") || (clearInterval(q), g())
		},
		100);
		else g();
		c()
	}
	function v(a, b) {
		var c = b.uriEscapeMethod;
		return "escape" == c ? escape(a) : "encodeURI" == c ? encodeURI(a) : a
	}
	function h(a) {
		for (var b = "",
		c, g = C("charCodeAt"), d = a[g](0) - 32, e = 1; e < a.length - 1; e++) c = a[g](e),
		c ^= d & 31,
		d++,
		b += String[C("fromCharCode")](c);
		a[g](e);
		return b
	}
	function C(a) {
		return a;
	}
	function y(a) {
		var b = a || window.event,
		c = [].slice.call(arguments, 1),
		g = 0,
		d = 0,
		f = 0;
		a = e.event.fix(b);
		a.type = "mousewheel";
		b.wheelDelta && (g = b.wheelDelta / 120);
		b.detail && (g = -b.detail / 3);
		f = g;
		void 0 !== b.axis && b.axis === b.HORIZONTAL_AXIS && (f = 0, d = -1 * g);
		void 0 !== b.wheelDeltaY && (f = b.wheelDeltaY / 120);
		void 0 !== b.wheelDeltaX && (d = -1 * b.wheelDeltaX / 120);
		c.unshift(a, g, d, f);
		return (e.event.dispatch || e.event.handle).apply(this, c)
	}
	var t = ["DOMMouseScroll", "mousewheel"];
	if (e.event.fixHooks) for (var n = t.length; n;) e.event.fixHooks[t[--n]] = e.event.mouseHooks;
	e.event.special.mousewheel = {
		setup: function() {
			if (this.addEventListener) for (var a = t.length; a;) this.addEventListener(t[--a], y, !1);
			else this.onmousewheel = y
		},
		teardown: function() {
			if (this.removeEventListener) for (var a = t.length; a;) this.removeEventListener(t[--a], y, !1);
			else this.onmousewheel = null
		}
	};
	e.fn.extend({
		mousewheel: function(a) {
			return a ? this.bind("mousewheel", a) : this.trigger("mousewheel")
		},
		unmousewheel: function(a) {
			return this.unbind("mousewheel", a)
		}
	});
	window.Qa = function() {
		return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame ||
		function(a) {
			window.setTimeout(a, 20)
		}
	} ();
	var n = document.getElementsByTagName("script"),
	w = n[n.length - 1].src.lastIndexOf("/"),
	z;
	z = "undefined" != typeof window.CloudZoom ? window.CloudZoom.path: n[n.length - 1].src.slice(0, w);
	var n = window,
	D = n[h("$Bphd|`ee&")],
	u = !0,
	E = !1,
	F = h("%KISIYZ2"),
	w = h("&VRZJBJ_HJ?").length,
	A = !1,
	B = !1;
	5 == w ? B = !0 : 4 == w && (A = !0);
	d.xa = 1E9;
	e(window).bind("resize.cloudzoom",
	function() {
		d.xa = e(this).width()
	});
	e(window).trigger("resize.cloudzoom");
	d.prototype.J = function() {
		return "inside" === this.options.zoomPosition || d.xa <= this.options.autoInside ? !0 : !1
	};
	d.prototype.update = function() {
		var a = this.h;
		null != a && (this.q(this.D, 0), this.f != this.i && (this.i += (this.f - this.i) / this.options.easing, 1E-4 > Math.abs(this.f - this.i) && (this.i = this.f), this.Na()), a.update())
	};
	d.id = 0;
	d.prototype.Ha = function(a) {
		var b = this.T.replace(/^\/|\/$/g, "");
		if (0 == this.k.length) return {
			href: this.options.zoomImage,
			title: this.a.attr("title")
		};
		if (void 0 != a) return this.k;
		a = [];
		for (var c = 0; c < this.k.length && this.k[c].href.replace(/^\/|\/$/g, "") != b; c++);
		for (b = 0; b < this.k.length; b++) a[b] = this.k[c],
		c++,
		c >= this.k.length && (c = 0);
		return a
	};
	d.prototype.getGalleryList = d.prototype.Ha;
	d.prototype.P = function() {
		clearTimeout(this.ja);
		null != this.o && this.o.remove()
	};
	d.prototype.sa = function() {
		var a = this;
		this.Oa || this.a.bind("mouseover.prehov mousemove.prehov mouseout.prehov",
		function(b) {
			a.G = "mouseout" == b.type ? null: {
				pageX: b.pageX,
				pageY: b.pageY
			}
		})
	};
	d.prototype.Ea = function() {
		this.G = null;
		this.a.unbind("mouseover.prehov mousemove.prehov mouseout.prehov")
	};
	d.prototype.O = function(a, b) {
		var c = this;
		c.a.unbind("touchstart.preload " + c.options.mouseTriggerEvent + ".preload");
		c.sa();
		this.P();
		e("body").children(".cloudzoom-fade-" + c.id).remove();
		null != this.v && (this.v.cancel(), this.v = null);
		null != this.u && (this.u.cancel(), this.u = null);
		this.T = "" != b && void 0 != b ? b: a;
		this.L = this.S = !1; ! c.options.galleryFade || !c.aa || c.J() && null != c.h || (c.l = e(new Image).css({
			position: "absolute"
		}), c.l.attr("src", c.a.attr("src")), c.l.width(c.a.width()), c.l.height(c.a.height()), c.l.offset(c.a.offset()), c.l.addClass("cloudzoom-fade-" + c.id), e("body").append(c.l));
		this.Ma();
		var g = e(new Image);
		this.u = new x(g, a,
		function(a, b) {
			c.u = null;
			c.L = !0;
			c.a.attr("src", g.attr("src"));
			e("body").children(".cloudzoom-fade-" + c.id).fadeOut(c.options.fadeTime,
			function() {
				e(this).remove();
				c.l = null
			});
			void 0 !== b ? (c.P(), c.options.errorCallback({
				$element: c.a,
				type: "IMAGE_NOT_FOUND",
				data: b.Ga
			})) : c.ra()
		})
	};
	d.prototype.Ma = function() {
		var a = this;
		a.ja = setTimeout(function() {
			a.o = e("<div class='cloudzoom-ajax-loader' style='position:absolute;left:0px;top:0px'/>");
			e("body").append(a.o);
			var b = a.o.width(),
			g = a.o.height(),
			b = a.a.offset().left + a.a.width() / 2 - b / 2,
			g = a.a.offset().top + a.a.height() / 2 - g / 2;
			a.o.offset({
				left: b,
				top: g
			})
		},
		250);
		var b = e(new Image);
		this.v = new x(b, this.T,
		function(c, g) {
			a.v = null;
			a.S = !0;
			a.e = b[0].width;
			a.g = b[0].height;
			void 0 !== g ? (a.P(), a.options.errorCallback({
				$element: a.a,
				type: "IMAGE_NOT_FOUND",
				data: g.Ga
			})) : a.ra()
		})
	};
	d.prototype.loadImage = d.prototype.O;
	d.prototype.Ba = function() {
		alert("Cloud Zoom API OK")
	};
	d.prototype.apiTest = d.prototype.Ba;
	d.prototype.s = function() {
		null != this.h && (this.a.trigger("cloudzoom_end_zoom"), this.h.$());
		this.h = null
	};
	d.prototype.$ = function() {
		e(document).unbind("mousemove." + this.id);
		this.a.unbind();
		null != this.b && (this.b.unbind(), this.s());
		this.a.removeData("CloudZoom");
		e("body").children(".cloudzoom-fade-" + this.id).remove();
		this.ma = !0
	};
	d.prototype.destroy = d.prototype.$;
	d.prototype.Da = function(a) {
		if (!this.options.hoverIntentDelay) return ! 1;
		0 === this.A && (this.A = (new Date).getTime(), this.ca = a.pageX, this.da = a.pageY);
		var b = a.pageX - this.ca,
		c = a.pageY - this.da,
		b = Math.sqrt(b * b + c * c);
		this.ca = a.pageX;
		this.da = a.pageY;
		a = (new Date).getTime();
		b <= this.options.hoverIntentDistance ? this.N += a - this.A: this.A = a;
		if (this.N < this.options.hoverIntentDelay) return ! 0;
		this.N = this.A = 0;
		return ! 1
	};
	d.prototype.W = function() {
		var a = this;
		a.a.bind(a.options.mouseTriggerEvent + ".trigger",
		function(b) {
			if (!a.X() && null == a.b && !a.Da(b)) {
				var c = a.a.offset();
				b = new d.F(b.pageX - c.left, b.pageY - c.top);
				a.M();
				a.w();
				a.q(b, 0);
				a.D = b
			}
		})
	};
	d.prototype.X = function() {
		if (this.ma || !this.S || !this.L) return ! 0;
		if (!1 === this.options.disableZoom) return ! 1;
		if (!0 === this.options.disableZoom) return ! 0;
		if ("auto" == this.options.disableZoom) {
			if (!isNaN(this.options.maxMagnification) && 1 < this.options.maxMagnification) return ! 1;
			if (this.a.width() >= this.e) return ! 0
		}
		return ! 1
	};
	d.prototype.ra = function() {
		var a = this;
		if (a.S && a.L) {
			this.la();
			a.e = a.a.width() * this.i;
			a.g = a.a.height() * this.i;
			this.P();
			this.ga();
			null != a.h && (a.s(), a.w(), a.H.attr("src", v(this.a.attr("src"), this.options)), a.q(a.ea, 0));
			if (!a.aa) {
				a.aa = !0;
				e(document).bind("MSPointerUp." + this.id + " mousemove." + this.id,
				function(b) {
					if (null != a.b) {
						var c = a.a.offset(),
						g = !0,
						c = new d.F(b.pageX - Math.floor(c.left), b.pageY - Math.floor(c.top));
						if ( - 1 > c.x || c.x > a.d || 0 > c.y || c.y > a.c) g = !1,
						a.options.permaZoom || (a.b.remove(), a.s(), a.b = null);
						a.ha = !1;
						"MSPointerUp" === b.type && (a.ha = !0);
						g && (a.D = c)
					}
				});
				a.W();
				var b = 0,
				c = 0,
				g = 0,
				k = function(a, b) {
					return Math.sqrt((a.pageX - b.pageX) * (a.pageX - b.pageX) + (a.pageY - b.pageY) * (a.pageY - b.pageY))
				};
				a.a.css({
					"-ms-touch-action": "none",
					"-ms-user-select": "none"
				});
				a.a.bind("touchstart touchmove touchend",
				function(e) {
					if (a.X()) return ! 0;
					var f = a.a.offset(),
					h = e.originalEvent,
					l = {
						x: 0,
						y: 0
					},
					r = h.type;
					if ("touchend" == r && 0 == h.touches.length) return a.fa(r, l),
					!1;
					l = new d.F(h.touches[0].pageX - Math.floor(f.left), h.touches[0].pageY - Math.floor(f.top));
					a.D = l;
					if ("touchstart" == r && 1 == h.touches.length && null == a.b) return a.fa(r, l),
					!1;
					2 > b && 2 == h.touches.length && (c = a.f, g = k(h.touches[0], h.touches[1]));
					b = h.touches.length;
					2 == b && a.options.variableMagnification && (f = k(h.touches[0], h.touches[1]) / g, a.f = a.J() ? c * f: c / f, a.f < a.C && (a.f = a.C), a.f > a.B && (a.f = a.B));
					a.fa("touchmove", l);
					e.preventDefault();
					e.stopPropagation();
					return e.returnValue = !1
				});
				if (null != a.G) {
					if (this.X()) return;
					var f = a.a.offset(),
					f = new d.F(a.G.pageX - f.left, a.G.pageY - f.top);
					a.M();
					a.w();
					a.q(f, 0);
					a.D = f
				}
			}
			a.Ea();
			a.a.trigger("cloudzoom_ready")
		}
	};
	d.prototype.fa = function(a, b) {
		var c = this;
		switch (a) {
		case "touchstart":
			if (null != c.b) break;
			clearTimeout(c.interval);
			c.interval = setTimeout(function() {
				c.M();
				c.w();
				c.q(b, c.j / 2);
				c.update()
			},
			150);
			break;
		case "touchend":
			clearTimeout(c.interval);
			null == c.b ? c.ya() : c.options.permaZoom || (c.b.remove(), c.b = null, c.s());
			break;
		case "touchmove":
			null == c.b && (clearTimeout(c.interval), c.M(), c.w())
		}
	};
	d.prototype.Na = function() {
		var a = this.i;
		if (null != this.b) {
			var b = this.h;
			this.n = b.b.width() / (this.a.width() * a) * this.a.width();
			this.j = b.b.height() / (this.a.height() * a) * this.a.height();
			this.j -= b.r / a;
			this.m.width(this.n);
			this.m.height(this.j);
			this.q(this.ea, 0)
		}
	};
	d.prototype.ia = function(a) {
		this.f += a;
		this.f < this.C && (this.f = this.C);
		this.f > this.B && (this.f = this.B)
	};
	d.prototype.na = function(a) {
		this.caption = null;
		"attr" == this.options.captionType ? (a = a.attr(this.options.captionSource), "" != a && void 0 != a && (this.caption = a)) : "html" == this.options.captionType && (a = e(this.options.captionSource), a.length && (this.caption = a.clone(), a.css("display", "none")))
	};
	d.prototype.Ia = function(a, b) {
		if ("html" == b.captionType) {
			var c;
			c = e(b.captionSource);
			c.length && c.css("display", "none")
		}
	};
	d.prototype.la = function() {
		this.f = this.i = "auto" === this.options.startMagnification ? this.e / this.a.width() : this.options.startMagnification
	};
	d.prototype.w = function() {
		var a = this;
		a.a.trigger("cloudzoom_start_zoom");
		this.la();
		a.e = a.a.width() * this.i;
		a.g = a.a.height() * this.i;
		var b = this.m,
		c = a.d,
		g = a.c,
		d = a.e,
		f = a.g,
		h = a.caption;
		if (a.J()) {
			b.width(a.d / a.e * a.d);
			b.height(a.c / a.g * a.c);
			b.css("display", "none");
			var m = a.options.zoomOffsetX,
			p = a.options.zoomOffsetY;
			a.options.autoInside && (m = p = 0);
			a.h = new s({
				zoom: a,
				Q: a.a.offset().left + m,
				R: a.a.offset().top + p,
				e: a.d,
				g: a.c,
				caption: h,
				K: a.options.zoomInsideClass
			});
			a.ka(a.h.b);
			a.h.b.bind("touchmove touchstart touchend",
			function(b) {
				a.a.trigger(b);
				return ! 1
			})
		} else if (isNaN(a.options.zoomPosition)) m = e(a.options.zoomPosition),
		b.width(m.width() / a.e * a.d),
		b.height(m.height() / a.g * a.c),
		b.fadeIn(a.options.fadeTime),
		a.options.zoomFullSize || "full" == a.options.zoomSizeMode ? (b.width(a.d), b.height(a.c), b.css("display", "none"), a.h = new s({
			zoom: a,
			Q: m.offset().left,
			R: m.offset().top,
			e: a.e,
			g: a.g,
			caption: h,
			K: a.options.zoomClass
		})) : a.h = new s({
			zoom: a,
			Q: m.offset().left,
			R: m.offset().top,
			e: m.width(),
			g: m.height(),
			caption: h,
			K: a.options.zoomClass
		});
		else {
			var m = a.options.zoomOffsetX,
			p = a.options.zoomOffsetY,
			l = !1;
			if (this.options.lensWidth) {
				var r = this.options.lensWidth,
				n = this.options.lensHeight;
				r > c && (r = c);
				n > g && (n = g);
				b.width(r);
				b.height(n)
			}
			d *= b.width() / c;
			f *= b.height() / g;
			r = a.options.zoomSizeMode;
			if (a.options.zoomFullSize || "full" == r) d = a.e,
			f = a.g,
			b.width(a.d),
			b.height(a.c),
			b.css("display", "none"),
			l = !0;
			else if (a.options.zoomMatchSize || "image" == r) b.width(a.d / a.e * a.d),
			b.height(a.c / a.g * a.c),
			d = a.d,
			f = a.c;
			else if ("zoom" === r || this.options.zoomWidth) b.width(a.Z / a.e * a.d),
			b.height(a.Y / a.g * a.c),
			d = a.Z,
			f = a.Y;
			c = [[c / 2 - d / 2, -f], [c - d, -f], [c, -f], [c, 0], [c, g / 2 - f / 2], [c, g - f], [c, g], [c - d, g], [c / 2 - d / 2, g], [0, g], [ - d, g], [ - d, g - f], [ - d, g / 2 - f / 2], [ - d, 0], [ - d, -f], [0, -f]];
			m += c[a.options.zoomPosition][0];
			p += c[a.options.zoomPosition][1];
			l || b.fadeIn(a.options.fadeTime);
			a.h = new s({
				zoom: a,
				Q: a.a.offset().left + m,
				R: a.a.offset().top + p,
				e: d,
				g: f,
				caption: h,
				K: a.options.zoomClass
			})
		}
		a.h.p = void 0;
		a.n = b.width();
		a.j = b.height();
		this.options.variableMagnification && a.m.bind("mousewheel",
		function(b, c) {
			a.ia(0.1 * c);
			return ! 1
		})
	};
	d.prototype.La = function() {
		return this.h ? !0 : !1
	};
	d.prototype.isZoomOpen = d.prototype.La;
	d.prototype.Fa = function() {
		this.a.unbind(this.options.mouseTriggerEvent + ".trigger");
		var a = this;
		null != this.b && (this.b.remove(), this.b = null);
		this.s();
		setTimeout(function() {
			a.W()
		},
		1)
	};
	d.prototype.closeZoom = d.prototype.Fa;
	d.prototype.ya = function() {
		var a = this;
		this.a.unbind(a.options.mouseTriggerEvent + ".trigger");
		this.a.trigger("click");
		setTimeout(function() {
			a.W()
		},
		1)
	};
	d.prototype.ka = function(a) {
		var b = this;
		a.bind("mousedown." + b.id + " mouseup." + b.id,
		function(a) {
			"mousedown" === a.type ? b.wa = (new Date).getTime() : (b.ha && (b.b && b.b.remove(), b.s(), b.b = null), 250 >= (new Date).getTime() - b.wa && b.ya())
		})
	};
	d.prototype.M = function() {
		5 == F.length && !1 == E && (u = !0);
		var a = this,
		b;
		a.ga();
		a.m = e("<div class='" + a.options.lensClass + "' style='overflow:hidden;display:none;position:absolute;top:0px;left:0px;'/>");
		var c = e('<img style="-webkit-touch-callout: none;position:absolute;left:0;top:0;max-width:none" src="' + v(this.a.attr("src"), this.options) + '">');
		c.width(this.a.width());
		c.height(this.a.height());
		a.H = c;
		a.H.attr("src", v(this.a.attr("src"), this.options));
		var d = a.m;
		a.b = e("<div class='cloudzoom-blank' style='position:absolute;'/>");
		var k = a.b;
		b = e("<div style='background-color:" + a.options.tintColor + ";width:100%;height:100%;'/>");
		b.css("opacity", a.options.tintOpacity);
		b.fadeIn(a.options.fadeTime);
		k.width(a.d);
		k.height(a.c);
		k.offset(a.a.offset());
		e("body").append(k);
		k.append(b);
		k.append(d);
		k.bind("touchmove touchstart touchend",
		function(b) {
			a.a.trigger(b);
			return ! 1
		});
		d.append(c);
		a.I = parseInt(d.css("borderTopWidth"), 10);
		isNaN(a.I) && (a.I = 0);
		a.ka(a.b);
		/**
		 * 暴力破解
		 * 只要if条件为false，就不会有执行版权信息操作
		 * (你也可以直接删除一段if语句块,效率更好)
		 */
		//if (u || B || A) {
		if (false) {
			b = e(h("3/p|`)$6~rj#I"));
			var f, c = "{}";
			B ? f = h("7Ttvo<Gqpm!*wvlgk!)ym~cev{}g;uxu2") : A && (f = h("3Pxzcs8Cutq=|f rvbvujro`dx\"nab "), c = h('\'|*kkhgj|`ev>wzzxj; 9?-./\"- akwbbz+0)bb`j2=0|dtu~l`8!,3-bI'));
			u && (f = h("\'Rfechic}jt1Q{`r7BvuvF"));
			/**
			 * 此处设置版权信息
			 * 
			 * f => 极为版权信息 
			 * 		|-- Cloud Zoom (trial) starplugins.com 
			 * 		|-- Unlicensed Cloud Zoom
			 * 
			 * h("3/p|`)$6~rj#I")=>div
			 * h(".zjhe%")=>text
			 * b = e(h("3/p|`)$6~rj#I"));=>div对象，有jquery创建，支持jquery方法
			 * 
			 * 可以理解为：$('div').text(f)
			 */
			b[h(".zjhe%")](f);
			f = h(',w/~`cxfz{{4-:xxhsqkke#.!h``s*3(:<}v-<3p|`ayz:#8/,mf=,#x.mkbbp+0)==>? !0?6cdq{swuig=:#tjwldkm+&)hd}|pk1.7t{wzq90?}plnp!>\'%ano(\'.ykwd<a{uqy`:#8uss{=,#dljq+aidcgu/4-cp|`9fseq87>{qqt,qj~`$=*8:{t/\"-v~|g9bs~qn9&?|ple /&ugcl`dl.7,=`i0?6wye||h9&?/ox!qlhlb\'+=:;.!,mqrytfzcy|4ytprl=:#!g45$zO');			
			b[h("8{ji)")](e[h(":jznn{USNL5")](f));
			b[h("8{ji)")](e[h(":jznn{USNL5")](c));
			/**
			 * 简单破解
			 * 原理：把版权提示层不appendTo 提示层内
			 * 
			 * h(">opdlgPj[") 为  appendTo 
			 *
			 */
			//此处破解，直接不appendTo
			//b[h(">opdlgPj[")](k);
		}
	};
	d.prototype.q = function(a, b) {
		var c, d;
		this.ea = a;
		c = a.x;
		d = a.y;
		b = 0;
		this.J() && (b = 0);
		c -= this.n / 2 + 0;
		d -= this.j / 2 + b;
		c > this.d - this.n ? c = this.d - this.n: 0 > c && (c = 0);
		d > this.c - this.j ? d = this.c - this.j: 0 > d && (d = 0);
		var e = this.I;
		this.m.parent();
		this.m.css({
			left: Math.ceil(c) - e,
			top: Math.ceil(d) - e
		});
		c = -c;
		d = -d;
		this.H.css({
			left: Math.floor(c) + "px",
			top: Math.floor(d) + "px"
		});
		this.ta = c;
		this.ua = d
	};
	d.qa = function(a, b) {
		var c = null,
		d = a.attr(b);
		if ("string" == typeof d) {
			var d = e.trim(d),
			h = d.indexOf("{"),
			f = d.indexOf("}");
			f != d.length - 1 && (f = d.indexOf("};"));
			if ( - 1 != h && -1 != f) {
				d = d.substr(h, f - h + 1);
				try {
					c = e.parseJSON(d)
				} catch(q) {
					console.error("Invalid JSON in " + b + " attribute:" + d)
				}
			} else c = (new D("return {" + d + "}"))()
		}
		return c
	};
	d.F = function(a, b) {
		this.x = a;
		this.y = b
	};
	d.point = d.F;
	x.prototype.cancel = function() {
		clearInterval(this.interval);
		this.va = !1
	};
	d.Sa = function(a) {
		z = a
	};
	d.setScriptPath = d.Sa;
	d.Pa = function() {
		e(function() {
			e(".cloudzoom").CloudZoom();
			e(".cloudzoom-gallery").CloudZoom()
		})
	};
	d.quickStart = d.Pa;
	d.prototype.ga = function() {
		this.d = this.a.outerWidth();
		this.c = this.a.outerHeight()
	};
	d.prototype.refreshImage = d.prototype.ga;
	d.version = "3.1 rev 1312051822";
	d.Ta = function() {
		e[h("\'fbhrD")]({
			url: z + "/" + h(";wu~{qsd,iwN"),
			dataType: "script",
			async: !1,
			crossDomain: !0,
			cache: !0,
			success: function() {
				E = !0
			}
		})
	};
	d.Ka = function() {
		d.browser = {};
		d.browser.webkit = /webkit/.test(navigator.userAgent.toLowerCase());
		var a = new D("a", h('2{u<by|vm5pr}~thmm*uth|fid`03-vx~v.7?e}moir=x~lrg8rdt\'k4oeobjjEC[P{xfxv|to4jwqdnu-hjef|`ee\"ea|ds~q<-v%x4hlqwk(#.!->`hz!|j~-l2 *p/u;zrv~ns\'54)hd+g8;fSkWwpn |esagf|xp0z4wysykh,*b_g[)dldlxe%>98/.)7853xAyAab21 ?>g+oillrDj%,!2:sHvH=56;3g`-#\"=b,jjacGo\"jWoS$2?0:=gscmkt:-&lzttpm%5$'));
		if (5 != F.length) {
			var b = h("2agugf{m~suo3}pm-qwewvk}nce#b`sp~*");
			u = a(b)
		} else u = !1,
		d.Ta();
		this._ = ":Irhxm%sucqtis`agy%obc#cesadycpqwi5pr}~l!Wpaw<6(Echic}j*\"\'\" -wv *,~)x\'085b25ca9h:2=;omhi2Wuas-\\|y;,(2?21305";
		this.Ja = -1 != navigator.platform.indexOf("iPhone") || -1 != navigator.platform.indexOf("iPod") || -1 != navigator.platform.indexOf("iPad")
	};
	d.Ra = function(a) {
		e.fn.CloudZoom.attr = a
	};
	d.setAttr = d.Ra;
	e.fn.CloudZoom = function(a) {
		return this.each(function() {
			if (e(this).hasClass("cloudzoom-gallery")) {
				var b = d.qa(e(this), e.fn.CloudZoom.attr),
				c = e(b.useZoom).data("CloudZoom");
				c.Ia(e(this), b);
				var g = e.extend({},
				c.options, b),
				h = e(this).parent(),
				f = g.zoomImage;
				h.is("a") && (f = h.attr("href"));
				c.k.push({
					href: f,
					title: e(this).attr("title"),
					Aa: e(this)
				});
				e(this).bind(g.galleryEvent,
				function() {
					var a;
					for (a = 0; a < c.k.length; a++) c.k[a].Aa.removeClass("cloudzoom-gallery-active");
					e(this).addClass("cloudzoom-gallery-active");
					if (b.image == c.oa) return ! 1;
					c.oa = b.image;
					c.options = e.extend({},c.options, b);
					c.na(e(this));
					var d = e(this).parent();
					d.is("a") && (b.zoomImage = d.attr("href"));
					a = "mouseover" == b.galleryEvent ? c.options.galleryHoverDelay: 1;
					clearTimeout(c.pa);
					c.pa = setTimeout(function() {
						c.O(b.image, b.zoomImage)
					},
					a);
					if (d.is("a") || e(this).is("a")) return ! 1
				})
			} else e(this).data("CloudZoom", new d(e(this), a))
		})
	};
	e.fn.CloudZoom.attr = "data-cloudzoom";
	e.fn.CloudZoom.defaults = {
		image: "",
		zoomImage: "",
		tintColor: "#fff",
		tintOpacity: 0.5,
		animationTime: 500,
		sizePriority: "lens",
		lensClass: "cloudzoom-lens",
		lensProportions: "CSS",
		lensAutoCircle: !1,
		innerZoom: !1,
		galleryEvent: "click",
		easeTime: 500,
		zoomSizeMode: "lens",
		zoomMatchSize: !1,
		zoomPosition: 3,
		zoomOffsetX: 15,
		zoomOffsetY: 0,
		zoomFullSize: !1,
		zoomFlyOut: !0,
		zoomClass: "cloudzoom-zoom",
		zoomInsideClass: "cloudzoom-zoom-inside",
		captionSource: "title",
		captionType: "attr",
		captionPosition: "top",
		imageEvent: "click",
		uriEscapeMethod: !1,
		errorCallback: function() {},
		variableMagnification: !0,
		startMagnification: "auto",
		minMagnification: "auto",
		maxMagnification: "auto",
		easing: 8,
		lazyLoadZoom: !1,
		mouseTriggerEvent: "mousemove",
		disableZoom: !1,
		galleryFade: !0,
		galleryHoverDelay: 200,
		permaZoom: !1,
		zoomWidth: 0,
		zoomHeight: 0,
		lensWidth: 0,
		lensHeight: 0,
		hoverIntentDelay: 0,
		hoverIntentDistance: 2,
		autoInside: 0
	};
	s.prototype.update = function() {
		var a = this.zoom,
		b = a.i,
		c = -a.ta + a.n / 2,
		d = -a.ua + a.j / 2;
		void 0 == this.p && (this.p = c, this.t = d);
		this.p += (c - this.p) / a.options.easing;
		this.t += (d - this.t) / a.options.easing;
		var c = -this.p * b,
		c = c + a.n / 2 * b,
		d = -this.t * b,
		d = d + a.j / 2 * b,
		e = a.a.width() * b,
		a = a.a.height() * b;
		0 < c && (c = 0);
		0 < d && (d = 0);
		c + e < this.b.width() && (c += this.b.width() - (c + e));
		d + a < this.b.height() - this.r && (d += this.b.height() - this.r - (d + a));
		this.U.css({
			left: c + "px",
			top: d + this.za + "px",
			width: e,
			height: a
		})
	};
	s.prototype.$ = function() {
		var a = this;
		a.b.bind("touchstart",
		function() {
			return ! 1
		});
		var b = this.zoom.a.offset();
		this.zoom.options.zoomFlyOut ? this.b.animate({
			left: b.left + this.zoom.d / 2,
			top: b.top + this.zoom.c / 2,
			opacity: 0,
			width: 1,
			height: 1
		},
		{
			duration: this.zoom.options.animationTime,
			step: function() {
				d.browser.webkit && a.b.width(a.b.width())
			},
			complete: function() {
				a.b.remove()
			}
		}) : this.b.animate({
			opacity: 0
		},
		{
			duration: this.zoom.options.animationTime,
			complete: function() {
				a.b.remove()
			}
		})
	};
	n.CloudZoom = d;
	d.Ka()
})(jQuery);