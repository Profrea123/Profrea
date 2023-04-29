(function (l, i, s, o) {
    function c(t, e) {
        (this.settings = null),
            (this.options = l.extend({}, c.Defaults, e)),
            (this.$element = l(t)),
            (this._handlers = {}),
            (this._plugins = {}),
            (this._supress = {}),
            (this._current = null),
            (this._speed = null),
            (this._coordinates = []),
            (this._breakpoint = null),
            (this._width = null),
            (this._items = []),
            (this._clones = []),
            (this._mergers = []),
            (this._widths = []),
            (this._invalidated = {}),
            (this._pipe = []),
            (this._drag = { time: null, target: null, pointer: null, stage: { start: null, current: null }, direction: null }),
            (this._states = { current: {}, tags: { initializing: ["busy"], animating: ["busy"], dragging: ["interacting"] } }),
            l.each(
                ["onResize", "onThrottledResize"],
                l.proxy(function (t, e) {
                    this._handlers[e] = l.proxy(this[e], this);
                }, this)
            ),
            l.each(
                c.Plugins,
                l.proxy(function (t, e) {
                    this._plugins[t.charAt(0).toLowerCase() + t.slice(1)] = new e(this);
                }, this)
            ),
            l.each(
                c.Workers,
                l.proxy(function (t, e) {
                    this._pipe.push({ filter: e.filter, run: l.proxy(e.run, this) });
                }, this)
            ),
            this.setup(),
            this.initialize();
    }
    (c.Defaults = {
        items: 3,
        loop: !1,
        center: !1,
        rewind: !1,
        mouseDrag: !0,
        touchDrag: !0,
        pullDrag: !0,
        freeDrag: !1,
        margin: 0,
        stagePadding: 0,
        merge: !1,
        mergeFit: !0,
        autoWidth: !1,
        startPosition: 0,
        rtl: !1,
        smartSpeed: 250,
        fluidSpeed: !1,
        dragEndSpeed: !1,
        responsive: {},
        responsiveRefreshRate: 200,
        responsiveBaseElement: i,
        fallbackEasing: "swing",
        info: !1,
        nestedItemSelector: !1,
        itemElement: "div",
        stageElement: "div",
        refreshClass: "owl-refresh",
        loadedClass: "owl-loaded",
        loadingClass: "owl-loading",
        rtlClass: "owl-rtl",
        responsiveClass: "owl-responsive",
        dragClass: "owl-drag",
        itemClass: "owl-item",
        stageClass: "owl-stage",
        stageOuterClass: "owl-stage-outer",
        grabClass: "owl-grab",
    }),
        (c.Width = { Default: "default", Inner: "inner", Outer: "outer" }),
        (c.Type = { Event: "event", State: "state" }),
        (c.Plugins = {}),
        (c.Workers = [
            {
                filter: ["width", "settings"],
                run: function () {
                    this._width = this.$element.width();
                },
            },
            {
                filter: ["width", "items", "settings"],
                run: function (t) {
                    t.current = this._items && this._items[this.relative(this._current)];
                },
            },
            {
                filter: ["items", "settings"],
                run: function () {
                    this.$stage.children(".cloned").remove();
                },
            },
            {
                filter: ["width", "items", "settings"],
                run: function (t) {
                    var e = this.settings.margin || "",
                        i = !this.settings.autoWidth,
                        n = this.settings.rtl,
                        s = { width: "auto", "margin-left": n ? e : "", "margin-right": n ? "" : e };
                    i || this.$stage.children().css(s), (t.css = s);
                },
            },
            {
                filter: ["width", "items", "settings"],
                run: function (t) {
                    var e = (this.width() / this.settings.items).toFixed(3) - this.settings.margin,
                        i = null,
                        n = this._items.length,
                        s = !this.settings.autoWidth,
                        o = [];
                    for (t.items = { merge: !1, width: e }; n--; )
                        (i = this._mergers[n]), (i = (this.settings.mergeFit && Math.min(i, this.settings.items)) || i), (t.items.merge = 1 < i || t.items.merge), (o[n] = s ? e * i : this._items[n].width());
                    this._widths = o;
                },
            },
            {
                filter: ["items", "settings"],
                run: function () {
                    var t = [],
                        e = this._items,
                        i = this.settings,
                        n = Math.max(2 * i.items, 4),
                        s = 2 * Math.ceil(e.length / 2),
                        o = i.loop && e.length ? (i.rewind ? n : Math.max(n, s)) : 0,
                        r = "",
                        a = "";
                    for (o /= 2; o--; ) t.push(this.normalize(t.length / 2, !0)), (r += e[t[t.length - 1]][0].outerHTML), t.push(this.normalize(e.length - 1 - (t.length - 1) / 2, !0)), (a = e[t[t.length - 1]][0].outerHTML + a);
                    (this._clones = t), l(r).addClass("cloned").appendTo(this.$stage), l(a).addClass("cloned").prependTo(this.$stage);
                },
            },
            {
                filter: ["width", "items", "settings"],
                run: function () {
                    for (var t = this.settings.rtl ? 1 : -1, e = this._clones.length + this._items.length, i = -1, n = 0, s = 0, o = []; ++i < e; )
                        (n = o[i - 1] || 0), (s = this._widths[this.relative(i)] + this.settings.margin), o.push(n + s * t);
                    this._coordinates = o;
                },
            },
            {
                filter: ["width", "items", "settings"],
                run: function () {
                    var t = this.settings.stagePadding,
                        e = this._coordinates,
                        i = { width: Math.ceil(Math.abs(e[e.length - 1])) + 2 * t, "padding-left": t || "", "padding-right": t || "" };
                    this.$stage.css(i);
                },
            },
            {
                filter: ["width", "items", "settings"],
                run: function (t) {
                    var e = this._coordinates.length,
                        i = !this.settings.autoWidth,
                        n = this.$stage.children();
                    if (i && t.items.merge) for (; e--; ) (t.css.width = this._widths[this.relative(e)]), n.eq(e).css(t.css);
                    else i && ((t.css.width = t.items.width), n.css(t.css));
                },
            },
            {
                filter: ["items"],
                run: function () {
                    this._coordinates.length < 1 && this.$stage.removeAttr("style");
                },
            },
            {
                filter: ["width", "items", "settings"],
                run: function (t) {
                    (t.current = t.current ? this.$stage.children().index(t.current) : 0), (t.current = Math.max(this.minimum(), Math.min(this.maximum(), t.current))), this.reset(t.current);
                },
            },
            {
                filter: ["position"],
                run: function () {
                    this.animate(this.coordinates(this._current));
                },
            },
            {
                filter: ["width", "position", "items", "settings"],
                run: function () {
                    var t,
                        e,
                        i,
                        n,
                        s = this.settings.rtl ? 1 : -1,
                        o = 2 * this.settings.stagePadding,
                        r = this.coordinates(this.current()) + o,
                        a = r + this.width() * s,
                        l = [];
                    for (i = 0, n = this._coordinates.length; i < n; i++)
                        (t = this._coordinates[i - 1] || 0), (e = Math.abs(this._coordinates[i]) + o * s), ((this.op(t, "<=", r) && this.op(t, ">", a)) || (this.op(e, "<", r) && this.op(e, ">", a))) && l.push(i);
                    this.$stage.children(".active").removeClass("active"),
                        this.$stage.children(":eq(" + l.join("), :eq(") + ")").addClass("active"),
                        this.settings.center && (this.$stage.children(".center").removeClass("center"), this.$stage.children().eq(this.current()).addClass("center"));
                },
            },
        ]),
        (c.prototype.initialize = function () {
            var t, e, i;
            this.enter("initializing"),
                this.trigger("initialize"),
                this.$element.toggleClass(this.settings.rtlClass, this.settings.rtl),
                this.settings.autoWidth &&
                    !this.is("pre-loading") &&
                    ((t = this.$element.find("img")), (e = this.settings.nestedItemSelector ? "." + this.settings.nestedItemSelector : o), (i = this.$element.children(e).width()), t.length && i <= 0 && this.preloadAutoWidthImages(t));
            this.$element.addClass(this.options.loadingClass),
                (this.$stage = l("<" + this.settings.stageElement + ' class="' + this.settings.stageClass + '"/>').wrap('<div class="' + this.settings.stageOuterClass + '"/>')),
                this.$element.append(this.$stage.parent()),
                this.replace(this.$element.children().not(this.$stage.parent())),
                this.$element.is(":visible") ? this.refresh() : this.invalidate("width"),
                this.$element.removeClass(this.options.loadingClass).addClass(this.options.loadedClass),
                this.registerEventHandlers(),
                this.leave("initializing"),
                this.trigger("initialized");
        }),
        (c.prototype.setup = function () {
            var e = this.viewport(),
                t = this.options.responsive,
                i = -1,
                n = null;
            t
                ? (l.each(t, function (t) {
                      t <= e && i < t && (i = Number(t));
                  }),
                  "function" == typeof (n = l.extend({}, this.options, t[i])).stagePadding && (n.stagePadding = n.stagePadding()),
                  delete n.responsive,
                  n.responsiveClass && this.$element.attr("class", this.$element.attr("class").replace(new RegExp("(" + this.options.responsiveClass + "-)\\S+\\s", "g"), "$1" + i)))
                : (n = l.extend({}, this.options)),
                this.trigger("change", { property: { name: "settings", value: n } }),
                (this._breakpoint = i),
                (this.settings = n),
                this.invalidate("settings"),
                this.trigger("changed", { property: { name: "settings", value: this.settings } });
        }),
        (c.prototype.optionsLogic = function () {
            this.settings.autoWidth && ((this.settings.stagePadding = !1), (this.settings.merge = !1));
        }),
        (c.prototype.prepare = function (t) {
            var e = this.trigger("prepare", { content: t });
            return (
                e.data ||
                    (e.data = l("<" + this.settings.itemElement + "/>")
                        .addClass(this.options.itemClass)
                        .append(t)),
                this.trigger("prepared", { content: e.data }),
                e.data
            );
        }),
        (c.prototype.update = function () {
            for (
                var t = 0,
                    e = this._pipe.length,
                    i = l.proxy(function (t) {
                        return this[t];
                    }, this._invalidated),
                    n = {};
                t < e;

            )
                (this._invalidated.all || 0 < l.grep(this._pipe[t].filter, i).length) && this._pipe[t].run(n), t++;
            (this._invalidated = {}), this.is("valid") || this.enter("valid");
        }),
        (c.prototype.width = function (t) {
            switch ((t = t || c.Width.Default)) {
                case c.Width.Inner:
                case c.Width.Outer:
                    return this._width;
                default:
                    return this._width - 2 * this.settings.stagePadding + this.settings.margin;
            }
        }),
        (c.prototype.refresh = function () {
            this.enter("refreshing"),
                this.trigger("refresh"),
                this.setup(),
                this.optionsLogic(),
                this.$element.addClass(this.options.refreshClass),
                this.update(),
                this.$element.removeClass(this.options.refreshClass),
                this.leave("refreshing"),
                this.trigger("refreshed");
        }),
        (c.prototype.onThrottledResize = function () {
            i.clearTimeout(this.resizeTimer), (this.resizeTimer = i.setTimeout(this._handlers.onResize, this.settings.responsiveRefreshRate));
        }),
        (c.prototype.onResize = function () {
            return (
                !!this._items.length &&
                this._width !== this.$element.width() &&
                !!this.$element.is(":visible") &&
                (this.enter("resizing"), this.trigger("resize").isDefaultPrevented() ? (this.leave("resizing"), !1) : (this.invalidate("width"), this.refresh(), this.leave("resizing"), void this.trigger("resized")))
            );
        }),
        (c.prototype.registerEventHandlers = function () {
            l.support.transition && this.$stage.on(l.support.transition.end + ".owl.core", l.proxy(this.onTransitionEnd, this)),
                !1 !== this.settings.responsive && this.on(i, "resize", this._handlers.onThrottledResize),
                this.settings.mouseDrag &&
                    (this.$element.addClass(this.options.dragClass),
                    this.$stage.on("mousedown.owl.core", l.proxy(this.onDragStart, this)),
                    this.$stage.on("dragstart.owl.core selectstart.owl.core", function () {
                        return !1;
                    })),
                this.settings.touchDrag && (this.$stage.on("touchstart.owl.core", l.proxy(this.onDragStart, this)), this.$stage.on("touchcancel.owl.core", l.proxy(this.onDragEnd, this)));
        }),
        (c.prototype.onDragStart = function (t) {
            var e = null;
            3 !== t.which &&
                ((e = l.support.transform
                    ? {
                          x: (e = this.$stage
                              .css("transform")
                              .replace(/.*\(|\)| /g, "")
                              .split(","))[16 === e.length ? 12 : 4],
                          y: e[16 === e.length ? 13 : 5],
                      }
                    : ((e = this.$stage.position()), { x: this.settings.rtl ? e.left + this.$stage.width() - this.width() + this.settings.margin : e.left, y: e.top })),
                this.is("animating") && (l.support.transform ? this.animate(e.x) : this.$stage.stop(), this.invalidate("position")),
                this.$element.toggleClass(this.options.grabClass, "mousedown" === t.type),
                this.speed(0),
                (this._drag.time = new Date().getTime()),
                (this._drag.target = l(t.target)),
                (this._drag.stage.start = e),
                (this._drag.stage.current = e),
                (this._drag.pointer = this.pointer(t)),
                l(s).on("mouseup.owl.core touchend.owl.core", l.proxy(this.onDragEnd, this)),
                l(s).one(
                    "mousemove.owl.core touchmove.owl.core",
                    l.proxy(function (t) {
                        var e = this.difference(this._drag.pointer, this.pointer(t));
                        l(s).on("mousemove.owl.core touchmove.owl.core", l.proxy(this.onDragMove, this)), (Math.abs(e.x) < Math.abs(e.y) && this.is("valid")) || (t.preventDefault(), this.enter("dragging"), this.trigger("drag"));
                    }, this)
                ));
        }),
        (c.prototype.onDragMove = function (t) {
            var e = null,
                i = null,
                n = null,
                s = this.difference(this._drag.pointer, this.pointer(t)),
                o = this.difference(this._drag.stage.start, s);
            this.is("dragging") &&
                (t.preventDefault(),
                this.settings.loop
                    ? ((e = this.coordinates(this.minimum())), (i = this.coordinates(this.maximum() + 1) - e), (o.x = ((((o.x - e) % i) + i) % i) + e))
                    : ((e = this.settings.rtl ? this.coordinates(this.maximum()) : this.coordinates(this.minimum())),
                      (i = this.settings.rtl ? this.coordinates(this.minimum()) : this.coordinates(this.maximum())),
                      (n = this.settings.pullDrag ? (-1 * s.x) / 5 : 0),
                      (o.x = Math.max(Math.min(o.x, e + n), i + n))),
                (this._drag.stage.current = o),
                this.animate(o.x));
        }),
        (c.prototype.onDragEnd = function (t) {
            var e = this.difference(this._drag.pointer, this.pointer(t)),
                i = this._drag.stage.current,
                n = (0 < e.x) ^ this.settings.rtl ? "left" : "right";
            l(s).off(".owl.core"),
                this.$element.removeClass(this.options.grabClass),
                ((0 !== e.x && this.is("dragging")) || !this.is("valid")) &&
                    (this.speed(this.settings.dragEndSpeed || this.settings.smartSpeed),
                    this.current(this.closest(i.x, 0 !== e.x ? n : this._drag.direction)),
                    this.invalidate("position"),
                    this.update(),
                    (this._drag.direction = n),
                    (3 < Math.abs(e.x) || 300 < new Date().getTime() - this._drag.time) &&
                        this._drag.target.one("click.owl.core", function () {
                            return !1;
                        })),
                this.is("dragging") && (this.leave("dragging"), this.trigger("dragged"));
        }),
        (c.prototype.closest = function (i, n) {
            var s = -1,
                o = this.width(),
                r = this.coordinates();
            return (
                this.settings.freeDrag ||
                    l.each(
                        r,
                        l.proxy(function (t, e) {
                            return (
                                "left" === n && e - 30 < i && i < e + 30
                                    ? (s = t)
                                    : "right" === n && e - o - 30 < i && i < e - o + 30
                                    ? (s = t + 1)
                                    : this.op(i, "<", e) && this.op(i, ">", r[t + 1] || e - o) && (s = "left" === n ? t + 1 : t),
                                -1 === s
                            );
                        }, this)
                    ),
                this.settings.loop || (this.op(i, ">", r[this.minimum()]) ? (s = i = this.minimum()) : this.op(i, "<", r[this.maximum()]) && (s = i = this.maximum())),
                s
            );
        }),
        (c.prototype.animate = function (t) {
            var e = 0 < this.speed();
            this.is("animating") && this.onTransitionEnd(),
                e && (this.enter("animating"), this.trigger("translate")),
                l.support.transform3d && l.support.transition
                    ? this.$stage.css({ transform: "translate3d(" + t + "px,0px,0px)", transition: this.speed() / 1e3 + "s" })
                    : e
                    ? this.$stage.animate({ left: t + "px" }, this.speed(), this.settings.fallbackEasing, l.proxy(this.onTransitionEnd, this))
                    : this.$stage.css({ left: t + "px" });
        }),
        (c.prototype.is = function (t) {
            return this._states.current[t] && 0 < this._states.current[t];
        }),
        (c.prototype.current = function (t) {
            if (t === o) return this._current;
            if (0 === this._items.length) return o;
            if (((t = this.normalize(t)), this._current !== t)) {
                var e = this.trigger("change", { property: { name: "position", value: t } });
                e.data !== o && (t = this.normalize(e.data)), (this._current = t), this.invalidate("position"), this.trigger("changed", { property: { name: "position", value: this._current } });
            }
            return this._current;
        }),
        (c.prototype.invalidate = function (t) {
            return (
                "string" === l.type(t) && ((this._invalidated[t] = !0), this.is("valid") && this.leave("valid")),
                l.map(this._invalidated, function (t, e) {
                    return e;
                })
            );
        }),
        (c.prototype.reset = function (t) {
            (t = this.normalize(t)) !== o && ((this._speed = 0), (this._current = t), this.suppress(["translate", "translated"]), this.animate(this.coordinates(t)), this.release(["translate", "translated"]));
        }),
        (c.prototype.normalize = function (t, e) {
            var i = this._items.length,
                n = e ? 0 : this._clones.length;
            return !this.isNumeric(t) || i < 1 ? (t = o) : (t < 0 || i + n <= t) && (t = ((((t - n / 2) % i) + i) % i) + n / 2), t;
        }),
        (c.prototype.relative = function (t) {
            return (t -= this._clones.length / 2), this.normalize(t, !0);
        }),
        (c.prototype.maximum = function (t) {
            var e,
                i,
                n,
                s = this.settings,
                o = this._coordinates.length;
            if (s.loop) o = this._clones.length / 2 + this._items.length - 1;
            else if (s.autoWidth || s.merge) {
                for (e = this._items.length, i = this._items[--e].width(), n = this.$element.width(); e-- && !(n < (i += this._items[e].width() + this.settings.margin)); );
                o = e + 1;
            } else o = s.center ? this._items.length - 1 : this._items.length - s.items;
            return t && (o -= this._clones.length / 2), Math.max(o, 0);
        }),
        (c.prototype.minimum = function (t) {
            return t ? 0 : this._clones.length / 2;
        }),
        (c.prototype.items = function (t) {
            return t === o ? this._items.slice() : ((t = this.normalize(t, !0)), this._items[t]);
        }),
        (c.prototype.mergers = function (t) {
            return t === o ? this._mergers.slice() : ((t = this.normalize(t, !0)), this._mergers[t]);
        }),
        (c.prototype.clones = function (i) {
            function n(t) {
                return t % 2 == 0 ? s + t / 2 : e - (t + 1) / 2;
            }
            var e = this._clones.length / 2,
                s = e + this._items.length;
            return i === o
                ? l.map(this._clones, function (t, e) {
                      return n(e);
                  })
                : l.map(this._clones, function (t, e) {
                      return t === i ? n(e) : null;
                  });
        }),
        (c.prototype.speed = function (t) {
            return t !== o && (this._speed = t), this._speed;
        }),
        (c.prototype.coordinates = function (t) {
            var e,
                i = 1,
                n = t - 1;
            return t === o
                ? l.map(
                      this._coordinates,
                      l.proxy(function (t, e) {
                          return this.coordinates(e);
                      }, this)
                  )
                : (this.settings.center ? (this.settings.rtl && ((i = -1), (n = t + 1)), (e = this._coordinates[t]), (e += ((this.width() - e + (this._coordinates[n] || 0)) / 2) * i)) : (e = this._coordinates[n] || 0),
                  (e = Math.ceil(e)));
        }),
        (c.prototype.duration = function (t, e, i) {
            return 0 === i ? 0 : Math.min(Math.max(Math.abs(e - t), 1), 6) * Math.abs(i || this.settings.smartSpeed);
        }),
        (c.prototype.to = function (t, e) {
            var i = this.current(),
                n = null,
                s = t - this.relative(i),
                o = (0 < s) - (s < 0),
                r = this._items.length,
                a = this.minimum(),
                l = this.maximum();
            this.settings.loop
                ? (!this.settings.rewind && Math.abs(s) > r / 2 && (s += -1 * o * r), (n = (((((t = i + s) - a) % r) + r) % r) + a) !== t && n - s <= l && 0 < n - s && ((i = n - s), (t = n), this.reset(i)))
                : (t = this.settings.rewind ? ((t % (l += 1)) + l) % l : Math.max(a, Math.min(l, t))),
                this.speed(this.duration(i, t, e)),
                this.current(t),
                this.$element.is(":visible") && this.update();
        }),
        (c.prototype.next = function (t) {
            (t = t || !1), this.to(this.relative(this.current()) + 1, t);
        }),
        (c.prototype.prev = function (t) {
            (t = t || !1), this.to(this.relative(this.current()) - 1, t);
        }),
        (c.prototype.onTransitionEnd = function (t) {
            if (t !== o && (t.stopPropagation(), (t.target || t.srcElement || t.originalTarget) !== this.$stage.get(0))) return !1;
            this.leave("animating"), this.trigger("translated");
        }),
        (c.prototype.viewport = function () {
            var t;
            return (
                this.options.responsiveBaseElement !== i
                    ? (t = l(this.options.responsiveBaseElement).width())
                    : i.innerWidth
                    ? (t = i.innerWidth)
                    : s.documentElement && s.documentElement.clientWidth
                    ? (t = s.documentElement.clientWidth)
                    : console.warn("Can not detect viewport width."),
                t
            );
        }),
        (c.prototype.replace = function (t) {
            this.$stage.empty(),
                (this._items = []),
                t && (t = t instanceof jQuery ? t : l(t)),
                this.settings.nestedItemSelector && (t = t.find("." + this.settings.nestedItemSelector)),
                t
                    .filter(function () {
                        return 1 === this.nodeType;
                    })
                    .each(
                        l.proxy(function (t, e) {
                            (e = this.prepare(e)), this.$stage.append(e), this._items.push(e), this._mergers.push(1 * e.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1);
                        }, this)
                    ),
                this.reset(this.isNumeric(this.settings.startPosition) ? this.settings.startPosition : 0),
                this.invalidate("items");
        }),
        (c.prototype.add = function (t, e) {
            var i = this.relative(this._current);
            (e = e === o ? this._items.length : this.normalize(e, !0)),
                (t = t instanceof jQuery ? t : l(t)),
                this.trigger("add", { content: t, position: e }),
                (t = this.prepare(t)),
                0 === this._items.length || e === this._items.length
                    ? (0 === this._items.length && this.$stage.append(t),
                      0 !== this._items.length && this._items[e - 1].after(t),
                      this._items.push(t),
                      this._mergers.push(1 * t.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1))
                    : (this._items[e].before(t), this._items.splice(e, 0, t), this._mergers.splice(e, 0, 1 * t.find("[data-merge]").addBack("[data-merge]").attr("data-merge") || 1)),
                this._items[i] && this.reset(this._items[i].index()),
                this.invalidate("items"),
                this.trigger("added", { content: t, position: e });
        }),
        (c.prototype.remove = function (t) {
            (t = this.normalize(t, !0)) !== o &&
                (this.trigger("remove", { content: this._items[t], position: t }),
                this._items[t].remove(),
                this._items.splice(t, 1),
                this._mergers.splice(t, 1),
                this.invalidate("items"),
                this.trigger("removed", { content: null, position: t }));
        }),
        (c.prototype.preloadAutoWidthImages = function (t) {
            t.each(
                l.proxy(function (t, e) {
                    this.enter("pre-loading"),
                        (e = l(e)),
                        l(new Image())
                            .one(
                                "load",
                                l.proxy(function (t) {
                                    e.attr("src", t.target.src), e.css("opacity", 1), this.leave("pre-loading"), this.is("pre-loading") || this.is("initializing") || this.refresh();
                                }, this)
                            )
                            .attr("src", e.attr("src") || e.attr("data-src") || e.attr("data-src-retina"));
                }, this)
            );
        }),
        (c.prototype.destroy = function () {
            for (var t in (this.$element.off(".owl.core"),
            this.$stage.off(".owl.core"),
            l(s).off(".owl.core"),
            !1 !== this.settings.responsive && (i.clearTimeout(this.resizeTimer), this.off(i, "resize", this._handlers.onThrottledResize)),
            this._plugins))
                this._plugins[t].destroy();
            this.$stage.children(".cloned").remove(),
                this.$stage.unwrap(),
                this.$stage.children().contents().unwrap(),
                this.$stage.children().unwrap(),
                this.$element
                    .removeClass(this.options.refreshClass)
                    .removeClass(this.options.loadingClass)
                    .removeClass(this.options.loadedClass)
                    .removeClass(this.options.rtlClass)
                    .removeClass(this.options.dragClass)
                    .removeClass(this.options.grabClass)
                    .attr("class", this.$element.attr("class").replace(new RegExp(this.options.responsiveClass + "-\\S+\\s", "g"), ""))
                    .removeData("owl.carousel");
        }),
        (c.prototype.op = function (t, e, i) {
            var n = this.settings.rtl;
            switch (e) {
                case "<":
                    return n ? i < t : t < i;
                case ">":
                    return n ? t < i : i < t;
                case ">=":
                    return n ? t <= i : i <= t;
                case "<=":
                    return n ? i <= t : t <= i;
            }
        }),
        (c.prototype.on = function (t, e, i, n) {
            t.addEventListener ? t.addEventListener(e, i, n) : t.attachEvent && t.attachEvent("on" + e, i);
        }),
        (c.prototype.off = function (t, e, i, n) {
            t.removeEventListener ? t.removeEventListener(e, i, n) : t.detachEvent && t.detachEvent("on" + e, i);
        }),
        (c.prototype.trigger = function (t, e, i, n, s) {
            var o = { item: { count: this._items.length, index: this.current() } },
                r = l.camelCase(
                    l
                        .grep(["on", t, i], function (t) {
                            return t;
                        })
                        .join("-")
                        .toLowerCase()
                ),
                a = l.Event([t, "owl", i || "carousel"].join(".").toLowerCase(), l.extend({ relatedTarget: this }, o, e));
            return (
                this._supress[t] ||
                    (l.each(this._plugins, function (t, e) {
                        e.onTrigger && e.onTrigger(a);
                    }),
                    this.register({ type: c.Type.Event, name: t }),
                    this.$element.trigger(a),
                    this.settings && "function" == typeof this.settings[r] && this.settings[r].call(this, a)),
                a
            );
        }),
        (c.prototype.enter = function (t) {
            l.each(
                [t].concat(this._states.tags[t] || []),
                l.proxy(function (t, e) {
                    this._states.current[e] === o && (this._states.current[e] = 0), this._states.current[e]++;
                }, this)
            );
        }),
        (c.prototype.leave = function (t) {
            l.each(
                [t].concat(this._states.tags[t] || []),
                l.proxy(function (t, e) {
                    this._states.current[e]--;
                }, this)
            );
        }),
        (c.prototype.register = function (i) {
            if (i.type === c.Type.Event) {
                if ((l.event.special[i.name] || (l.event.special[i.name] = {}), !l.event.special[i.name].owl)) {
                    var e = l.event.special[i.name]._default;
                    (l.event.special[i.name]._default = function (t) {
                        return !e || !e.apply || (t.namespace && -1 !== t.namespace.indexOf("owl")) ? t.namespace && -1 < t.namespace.indexOf("owl") : e.apply(this, arguments);
                    }),
                        (l.event.special[i.name].owl = !0);
                }
            } else
                i.type === c.Type.State &&
                    (this._states.tags[i.name] ? (this._states.tags[i.name] = this._states.tags[i.name].concat(i.tags)) : (this._states.tags[i.name] = i.tags),
                    (this._states.tags[i.name] = l.grep(
                        this._states.tags[i.name],
                        l.proxy(function (t, e) {
                            return l.inArray(t, this._states.tags[i.name]) === e;
                        }, this)
                    )));
        }),
        (c.prototype.suppress = function (t) {
            l.each(
                t,
                l.proxy(function (t, e) {
                    this._supress[e] = !0;
                }, this)
            );
        }),
        (c.prototype.release = function (t) {
            l.each(
                t,
                l.proxy(function (t, e) {
                    delete this._supress[e];
                }, this)
            );
        }),
        (c.prototype.pointer = function (t) {
            var e = { x: null, y: null };
            return (
                (t = (t = t.originalEvent || t || i.event).touches && t.touches.length ? t.touches[0] : t.changedTouches && t.changedTouches.length ? t.changedTouches[0] : t).pageX
                    ? ((e.x = t.pageX), (e.y = t.pageY))
                    : ((e.x = t.clientX), (e.y = t.clientY)),
                e
            );
        }),
        (c.prototype.isNumeric = function (t) {
            return !isNaN(parseFloat(t));
        }),
        (c.prototype.difference = function (t, e) {
            return { x: t.x - e.x, y: t.y - e.y };
        }),
        (l.fn.owlCarousel = function (e) {
            var n = Array.prototype.slice.call(arguments, 1);
            return this.each(function () {
                var t = l(this),
                    i = t.data("owl.carousel");
                i ||
                    ((i = new c(this, "object" == typeof e && e)),
                    t.data("owl.carousel", i),
                    l.each(["next", "prev", "to", "destroy", "refresh", "replace", "add", "remove"], function (t, e) {
                        i.register({ type: c.Type.Event, name: e }),
                            i.$element.on(
                                e + ".owl.carousel.core",
                                l.proxy(function (t) {
                                    t.namespace && t.relatedTarget !== this && (this.suppress([e]), i[e].apply(this, [].slice.call(arguments, 1)), this.release([e]));
                                }, i)
                            );
                    })),
                    "string" == typeof e && "_" !== e.charAt(0) && i[e].apply(i, n);
            });
        }),
        (l.fn.owlCarousel.Constructor = c);
})(window.Zepto || window.jQuery, window, document),
(function (e, i) {
    var n = function (t) {
        (this._core = t),
            (this._interval = null),
            (this._visible = null),
            (this._handlers = {
                "initialized.owl.carousel": e.proxy(function (t) {
                    t.namespace && this._core.settings.autoRefresh && this.watch();
                }, this),
            }),
            (this._core.options = e.extend({}, n.Defaults, this._core.options)),
            this._core.$element.on(this._handlers);
    };
    (n.Defaults = { autoRefresh: !0, autoRefreshInterval: 500 }),
        (n.prototype.watch = function () {
            this._interval || ((this._visible = this._core.$element.is(":visible")), (this._interval = i.setInterval(e.proxy(this.refresh, this), this._core.settings.autoRefreshInterval)));
        }),
        (n.prototype.refresh = function () {
            this._core.$element.is(":visible") !== this._visible &&
                ((this._visible = !this._visible), this._core.$element.toggleClass("owl-hidden", !this._visible), this._visible && this._core.invalidate("width") && this._core.refresh());
        }),
        (n.prototype.destroy = function () {
            var t, e;
            for (t in (i.clearInterval(this._interval), this._handlers)) this._core.$element.off(t, this._handlers[t]);
            for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null);
        }),
        (e.fn.owlCarousel.Constructor.Plugins.AutoRefresh = n);
})(window.Zepto || window.jQuery, window, document),
(function (a, o) {
    var e = function (t) {
        (this._core = t),
            (this._loaded = []),
            (this._handlers = {
                "initialized.owl.carousel change.owl.carousel resized.owl.carousel": a.proxy(function (t) {
                    if (t.namespace && this._core.settings && this._core.settings.lazyLoad && ((t.property && "position" == t.property.name) || "initialized" == t.type))
                        for (
                            var e = this._core.settings,
                                i = (e.center && Math.ceil(e.items / 2)) || e.items,
                                n = (e.center && -1 * i) || 0,
                                s = (t.property && void 0 !== t.property.value ? t.property.value : this._core.current()) + n,
                                o = this._core.clones().length,
                                r = a.proxy(function (t, e) {
                                    this.load(e);
                                }, this);
                            n++ < i;

                        )
                            this.load(o / 2 + this._core.relative(s)), o && a.each(this._core.clones(this._core.relative(s)), r), s++;
                }, this),
            }),
            (this._core.options = a.extend({}, e.Defaults, this._core.options)),
            this._core.$element.on(this._handlers);
    };
    (e.Defaults = { lazyLoad: !1 }),
        (e.prototype.load = function (t) {
            var e = this._core.$stage.children().eq(t),
                i = e && e.find(".owl-lazy");
            !i ||
                -1 < a.inArray(e.get(0), this._loaded) ||
                (i.each(
                    a.proxy(function (t, e) {
                        var i,
                            n = a(e),
                            s = (1 < o.devicePixelRatio && n.attr("data-src-retina")) || n.attr("data-src");
                        this._core.trigger("load", { element: n, url: s }, "lazy"),
                            n.is("img")
                                ? n
                                      .one(
                                          "load.owl.lazy",
                                          a.proxy(function () {
                                              n.css("opacity", 1), this._core.trigger("loaded", { element: n, url: s }, "lazy");
                                          }, this)
                                      )
                                      .attr("src", s)
                                : (((i = new Image()).onload = a.proxy(function () {
                                      n.css({ "background-image": 'url("' + s + '")', opacity: "1" }), this._core.trigger("loaded", { element: n, url: s }, "lazy");
                                  }, this)),
                                  (i.src = s));
                    }, this)
                ),
                this._loaded.push(e.get(0)));
        }),
        (e.prototype.destroy = function () {
            var t, e;
            for (t in this.handlers) this._core.$element.off(t, this.handlers[t]);
            for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null);
        }),
        (a.fn.owlCarousel.Constructor.Plugins.Lazy = e);
})(window.Zepto || window.jQuery, window, document),
(function (o) {
    var e = function (t) {
        (this._core = t),
            (this._handlers = {
                "initialized.owl.carousel refreshed.owl.carousel": o.proxy(function (t) {
                    t.namespace && this._core.settings.autoHeight && this.update();
                }, this),
                "changed.owl.carousel": o.proxy(function (t) {
                    t.namespace && this._core.settings.autoHeight && "position" == t.property.name && this.update();
                }, this),
                "loaded.owl.lazy": o.proxy(function (t) {
                    t.namespace && this._core.settings.autoHeight && t.element.closest("." + this._core.settings.itemClass).index() === this._core.current() && this.update();
                }, this),
            }),
            (this._core.options = o.extend({}, e.Defaults, this._core.options)),
            this._core.$element.on(this._handlers);
    };
    (e.Defaults = { autoHeight: !1, autoHeightClass: "owl-height" }),
        (e.prototype.update = function () {
            var t,
                e = this._core._current,
                i = e + this._core.settings.items,
                n = this._core.$stage.children().toArray().slice(e, i),
                s = [];
            o.each(n, function (t, e) {
                s.push(o(e).height());
            }),
                (t = Math.max.apply(null, s)),
                this._core.$stage.parent().height(t).addClass(this._core.settings.autoHeightClass);
        }),
        (e.prototype.destroy = function () {
            var t, e;
            for (t in this._handlers) this._core.$element.off(t, this._handlers[t]);
            for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null);
        }),
        (o.fn.owlCarousel.Constructor.Plugins.AutoHeight = e);
})(window.Zepto || window.jQuery, window, document),
(function (h, t, e) {
    var i = function (t) {
        (this._core = t),
            (this._videos = {}),
            (this._playing = null),
            (this._handlers = {
                "initialized.owl.carousel": h.proxy(function (t) {
                    t.namespace && this._core.register({ type: "state", name: "playing", tags: ["interacting"] });
                }, this),
                "resize.owl.carousel": h.proxy(function (t) {
                    t.namespace && this._core.settings.video && this.isInFullScreen() && t.preventDefault();
                }, this),
                "refreshed.owl.carousel": h.proxy(function (t) {
                    t.namespace && this._core.is("resizing") && this._core.$stage.find(".cloned .owl-video-frame").remove();
                }, this),
                "changed.owl.carousel": h.proxy(function (t) {
                    t.namespace && "position" === t.property.name && this._playing && this.stop();
                }, this),
                "prepared.owl.carousel": h.proxy(function (t) {
                    if (t.namespace) {
                        var e = h(t.content).find(".owl-video");
                        e.length && (e.css("display", "none"), this.fetch(e, h(t.content)));
                    }
                }, this),
            }),
            (this._core.options = h.extend({}, i.Defaults, this._core.options)),
            this._core.$element.on(this._handlers),
            this._core.$element.on(
                "click.owl.video",
                ".owl-video-play-icon",
                h.proxy(function (t) {
                    this.play(t);
                }, this)
            );
    };
    (i.Defaults = { video: !1, videoHeight: !1, videoWidth: !1 }),
        (i.prototype.fetch = function (t, e) {
            var i = t.attr("data-vimeo-id") ? "vimeo" : t.attr("data-vzaar-id") ? "vzaar" : "youtube",
                n = t.attr("data-vimeo-id") || t.attr("data-youtube-id") || t.attr("data-vzaar-id"),
                s = t.attr("data-width") || this._core.settings.videoWidth,
                o = t.attr("data-height") || this._core.settings.videoHeight,
                r = t.attr("href");
            if (!r) throw new Error("Missing video URL.");
            if (
                -1 <
                (n = r.match(
                    /(http:|https:|)\/\/(player.|www.|app.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com)|vzaar\.com)\/(video\/|videos\/|embed\/|channels\/.+\/|groups\/.+\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/
                ))[3].indexOf("youtu")
            )
                i = "youtube";
            else if (-1 < n[3].indexOf("vimeo")) i = "vimeo";
            else {
                if (!(-1 < n[3].indexOf("vzaar"))) throw new Error("Video URL not supported.");
                i = "vzaar";
            }
            (n = n[6]), (this._videos[r] = { type: i, id: n, width: s, height: o }), e.attr("data-video", r), this.thumbnail(t, this._videos[r]);
        }),
        (i.prototype.thumbnail = function (e, t) {
            function i(t) {
                '<div class="owl-video-play-icon"></div>',
                    (n = c.lazyLoad ? '<div class="owl-video-tn ' + l + '" ' + a + '="' + t + '"></div>' : '<div class="owl-video-tn" style="opacity:1;background-image:url(' + t + ')"></div>'),
                    e.after(n),
                    e.after('<div class="owl-video-play-icon"></div>');
            }
            var n,
                s,
                o = t.width && t.height ? 'style="width:' + t.width + "px;height:" + t.height + 'px;"' : "",
                r = e.find("img"),
                a = "src",
                l = "",
                c = this._core.settings;
            if ((e.wrap('<div class="owl-video-wrapper"' + o + "></div>"), this._core.settings.lazyLoad && ((a = "data-src"), (l = "owl-lazy")), r.length)) return i(r.attr(a)), r.remove(), !1;
            "youtube" === t.type
                ? ((s = "//img.youtube.com/vi/" + t.id + "/hqdefault.jpg"), i(s))
                : "vimeo" === t.type
                ? h.ajax({
                      type: "GET",
                      url: "//vimeo.com/api/v2/video/" + t.id + ".json",
                      jsonp: "callback",
                      dataType: "jsonp",
                      success: function (t) {
                          (s = t[0].thumbnail_large), i(s);
                      },
                  })
                : "vzaar" === t.type &&
                  h.ajax({
                      type: "GET",
                      url: "//vzaar.com/api/videos/" + t.id + ".json",
                      jsonp: "callback",
                      dataType: "jsonp",
                      success: function (t) {
                          (s = t.framegrab_url), i(s);
                      },
                  });
        }),
        (i.prototype.stop = function () {
            this._core.trigger("stop", null, "video"),
                this._playing.find(".owl-video-frame").remove(),
                this._playing.removeClass("owl-video-playing"),
                (this._playing = null),
                this._core.leave("playing"),
                this._core.trigger("stopped", null, "video");
        }),
        (i.prototype.play = function (t) {
            var e,
                i = h(t.target).closest("." + this._core.settings.itemClass),
                n = this._videos[i.attr("data-video")],
                s = n.width || "100%",
                o = n.height || this._core.$stage.height();
            this._playing ||
                (this._core.enter("playing"),
                this._core.trigger("play", null, "video"),
                (i = this._core.items(this._core.relative(i.index()))),
                this._core.reset(i.index()),
                "youtube" === n.type
                    ? (e = '<iframe width="' + s + '" height="' + o + '" src="//www.youtube.com/embed/' + n.id + "?autoplay=1&rel=0&v=" + n.id + '" frameborder="0" allowfullscreen></iframe>')
                    : "vimeo" === n.type
                    ? (e = '<iframe src="//player.vimeo.com/video/' + n.id + '?autoplay=1" width="' + s + '" height="' + o + '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>')
                    : "vzaar" === n.type && (e = '<iframe frameborder="0"height="' + o + '"width="' + s + '" allowfullscreen mozallowfullscreen webkitAllowFullScreen src="//view.vzaar.com/' + n.id + '/player?autoplay=true"></iframe>'),
                h('<div class="owl-video-frame">' + e + "</div>").insertAfter(i.find(".owl-video")),
                (this._playing = i.addClass("owl-video-playing")));
        }),
        (i.prototype.isInFullScreen = function () {
            var t = e.fullscreenElement || e.mozFullScreenElement || e.webkitFullscreenElement;
            return t && h(t).parent().hasClass("owl-video-frame");
        }),
        (i.prototype.destroy = function () {
            var t, e;
            for (t in (this._core.$element.off("click.owl.video"), this._handlers)) this._core.$element.off(t, this._handlers[t]);
            for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null);
        }),
        (h.fn.owlCarousel.Constructor.Plugins.Video = i);
})(window.Zepto || window.jQuery, window, document),
(function (r) {
    var e = function (t) {
        (this.core = t),
            (this.core.options = r.extend({}, e.Defaults, this.core.options)),
            (this.swapping = !0),
            (this.previous = void 0),
            (this.next = void 0),
            (this.handlers = {
                "change.owl.carousel": r.proxy(function (t) {
                    t.namespace && "position" == t.property.name && ((this.previous = this.core.current()), (this.next = t.property.value));
                }, this),
                "drag.owl.carousel dragged.owl.carousel translated.owl.carousel": r.proxy(function (t) {
                    t.namespace && (this.swapping = "translated" == t.type);
                }, this),
                "translate.owl.carousel": r.proxy(function (t) {
                    t.namespace && this.swapping && (this.core.options.animateOut || this.core.options.animateIn) && this.swap();
                }, this),
            }),
            this.core.$element.on(this.handlers);
    };
    (e.Defaults = { animateOut: !1, animateIn: !1 }),
        (e.prototype.swap = function () {
            if (1 === this.core.settings.items && r.support.animation && r.support.transition) {
                this.core.speed(0);
                var t,
                    e = r.proxy(this.clear, this),
                    i = this.core.$stage.children().eq(this.previous),
                    n = this.core.$stage.children().eq(this.next),
                    s = this.core.settings.animateIn,
                    o = this.core.settings.animateOut;
                this.core.current() !== this.previous &&
                    (o &&
                        ((t = this.core.coordinates(this.previous) - this.core.coordinates(this.next)),
                        i
                            .one(r.support.animation.end, e)
                            .css({ left: t + "px" })
                            .addClass("animated owl-animated-out")
                            .addClass(o)),
                    s && n.one(r.support.animation.end, e).addClass("animated owl-animated-in").addClass(s));
            }
        }),
        (e.prototype.clear = function (t) {
            r(t.target).css({ left: "" }).removeClass("animated owl-animated-out owl-animated-in").removeClass(this.core.settings.animateIn).removeClass(this.core.settings.animateOut), this.core.onTransitionEnd();
        }),
        (e.prototype.destroy = function () {
            var t, e;
            for (t in this.handlers) this.core.$element.off(t, this.handlers[t]);
            for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null);
        }),
        (r.fn.owlCarousel.Constructor.Plugins.Animate = e);
})(window.Zepto || window.jQuery, window, document),
(function (i, n, s) {
    var e = function (t) {
        (this._core = t),
            (this._timeout = null),
            (this._paused = !1),
            (this._handlers = {
                "changed.owl.carousel": i.proxy(function (t) {
                    t.namespace && "settings" === t.property.name
                        ? this._core.settings.autoplay
                            ? this.play()
                            : this.stop()
                        : t.namespace && "position" === t.property.name && this._core.settings.autoplay && this._setAutoPlayInterval();
                }, this),
                "initialized.owl.carousel": i.proxy(function (t) {
                    t.namespace && this._core.settings.autoplay && this.play();
                }, this),
                "play.owl.autoplay": i.proxy(function (t, e, i) {
                    t.namespace && this.play(e, i);
                }, this),
                "stop.owl.autoplay": i.proxy(function (t) {
                    t.namespace && this.stop();
                }, this),
                "mouseover.owl.autoplay": i.proxy(function () {
                    this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.pause();
                }, this),
                "mouseleave.owl.autoplay": i.proxy(function () {
                    this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.play();
                }, this),
                "touchstart.owl.core": i.proxy(function () {
                    this._core.settings.autoplayHoverPause && this._core.is("rotating") && this.pause();
                }, this),
                "touchend.owl.core": i.proxy(function () {
                    this._core.settings.autoplayHoverPause && this.play();
                }, this),
            }),
            this._core.$element.on(this._handlers),
            (this._core.options = i.extend({}, e.Defaults, this._core.options));
    };
    (e.Defaults = { autoplay: !1, autoplayTimeout: 5e3, autoplayHoverPause: !1, autoplaySpeed: !1 }),
        (e.prototype.play = function (t, e) {
            (this._paused = !1), this._core.is("rotating") || (this._core.enter("rotating"), this._setAutoPlayInterval());
        }),
        (e.prototype._getNextTimeout = function (t, e) {
            return (
                this._timeout && n.clearTimeout(this._timeout),
                n.setTimeout(
                    i.proxy(function () {
                        this._paused || this._core.is("busy") || this._core.is("interacting") || s.hidden || this._core.next(e || this._core.settings.autoplaySpeed);
                    }, this),
                    t || this._core.settings.autoplayTimeout
                )
            );
        }),
        (e.prototype._setAutoPlayInterval = function () {
            this._timeout = this._getNextTimeout();
        }),
        (e.prototype.stop = function () {
            this._core.is("rotating") && (n.clearTimeout(this._timeout), this._core.leave("rotating"));
        }),
        (e.prototype.pause = function () {
            this._core.is("rotating") && (this._paused = !0);
        }),
        (e.prototype.destroy = function () {
            var t, e;
            for (t in (this.stop(), this._handlers)) this._core.$element.off(t, this._handlers[t]);
            for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null);
        }),
        (i.fn.owlCarousel.Constructor.Plugins.autoplay = e);
})(window.Zepto || window.jQuery, window, document),
(function (o) {
    "use strict";
    var e = function (t) {
        (this._core = t),
            (this._initialized = !1),
            (this._pages = []),
            (this._controls = {}),
            (this._templates = []),
            (this.$element = this._core.$element),
            (this._overrides = { next: this._core.next, prev: this._core.prev, to: this._core.to }),
            (this._handlers = {
                "prepared.owl.carousel": o.proxy(function (t) {
                    t.namespace && this._core.settings.dotsData && this._templates.push('<div class="' + this._core.settings.dotClass + '">' + o(t.content).find("[data-dot]").addBack("[data-dot]").attr("data-dot") + "</div>");
                }, this),
                "added.owl.carousel": o.proxy(function (t) {
                    t.namespace && this._core.settings.dotsData && this._templates.splice(t.position, 0, this._templates.pop());
                }, this),
                "remove.owl.carousel": o.proxy(function (t) {
                    t.namespace && this._core.settings.dotsData && this._templates.splice(t.position, 1);
                }, this),
                "changed.owl.carousel": o.proxy(function (t) {
                    t.namespace && "position" == t.property.name && this.draw();
                }, this),
                "initialized.owl.carousel": o.proxy(function (t) {
                    t.namespace &&
                        !this._initialized &&
                        (this._core.trigger("initialize", null, "navigation"), this.initialize(), this.update(), this.draw(), (this._initialized = !0), this._core.trigger("initialized", null, "navigation"));
                }, this),
                "refreshed.owl.carousel": o.proxy(function (t) {
                    t.namespace && this._initialized && (this._core.trigger("refresh", null, "navigation"), this.update(), this.draw(), this._core.trigger("refreshed", null, "navigation"));
                }, this),
            }),
            (this._core.options = o.extend({}, e.Defaults, this._core.options)),
            this.$element.on(this._handlers);
    };
    (e.Defaults = {
        nav: !1,
        navText: ["prev", "next"],
        navSpeed: !1,
        navElement: "div",
        navContainer: !1,
        navContainerClass: "owl-nav",
        navClass: ["owl-prev", "owl-next"],
        slideBy: 1,
        dotClass: "owl-dot",
        dotsClass: "owl-dots",
        dots: !0,
        dotsEach: !1,
        dotsData: !1,
        dotsSpeed: !1,
        dotsContainer: !1,
    }),
        (e.prototype.initialize = function () {
            var t,
                i = this._core.settings;
            for (t in ((this._controls.$relative = (i.navContainer ? o(i.navContainer) : o("<div>").addClass(i.navContainerClass).appendTo(this.$element)).addClass("disabled")),
            (this._controls.$previous = o("<" + i.navElement + ">")
                .addClass(i.navClass[0])
                .html(i.navText[0])
                .prependTo(this._controls.$relative)
                .on(
                    "click",
                    o.proxy(function (t) {
                        this.prev(i.navSpeed);
                    }, this)
                )),
            (this._controls.$next = o("<" + i.navElement + ">")
                .addClass(i.navClass[1])
                .html(i.navText[1])
                .appendTo(this._controls.$relative)
                .on(
                    "click",
                    o.proxy(function (t) {
                        this.next(i.navSpeed);
                    }, this)
                )),
            i.dotsData || (this._templates = [o("<div>").addClass(i.dotClass).append(o("<span>")).prop("outerHTML")]),
            (this._controls.$absolute = (i.dotsContainer ? o(i.dotsContainer) : o("<div>").addClass(i.dotsClass).appendTo(this.$element)).addClass("disabled")),
            this._controls.$absolute.on(
                "click",
                "div",
                o.proxy(function (t) {
                    var e = o(t.target).parent().is(this._controls.$absolute) ? o(t.target).index() : o(t.target).parent().index();
                    t.preventDefault(), this.to(e, i.dotsSpeed);
                }, this)
            ),
            this._overrides))
                this._core[t] = o.proxy(this[t], this);
        }),
        (e.prototype.destroy = function () {
            var t, e, i, n;
            for (t in this._handlers) this.$element.off(t, this._handlers[t]);
            for (e in this._controls) this._controls[e].remove();
            for (n in this.overides) this._core[n] = this._overrides[n];
            for (i in Object.getOwnPropertyNames(this)) "function" != typeof this[i] && (this[i] = null);
        }),
        (e.prototype.update = function () {
            var t,
                e,
                i = this._core.clones().length / 2,
                n = i + this._core.items().length,
                s = this._core.maximum(!0),
                o = this._core.settings,
                r = o.center || o.autoWidth || o.dotsData ? 1 : o.dotsEach || o.items;
            if (("page" !== o.slideBy && (o.slideBy = Math.min(o.slideBy, o.items)), o.dots || "page" == o.slideBy))
                for (this._pages = [], t = i, e = 0; t < n; t++) {
                    if (r <= e || 0 === e) {
                        if ((this._pages.push({ start: Math.min(s, t - i), end: t - i + r - 1 }), Math.min(s, t - i) === s)) break;
                        (e = 0), 0;
                    }
                    e += this._core.mergers(this._core.relative(t));
                }
        }),
        (e.prototype.draw = function () {
            var t,
                e = this._core.settings,
                i = this._core.items().length <= e.items,
                n = this._core.relative(this._core.current()),
                s = e.loop || e.rewind;
            this._controls.$relative.toggleClass("disabled", !e.nav || i),
                e.nav && (this._controls.$previous.toggleClass("disabled", !s && n <= this._core.minimum(!0)), this._controls.$next.toggleClass("disabled", !s && n >= this._core.maximum(!0))),
                this._controls.$absolute.toggleClass("disabled", !e.dots || i),
                e.dots &&
                    ((t = this._pages.length - this._controls.$absolute.children().length),
                    e.dotsData && 0 != t
                        ? this._controls.$absolute.html(this._templates.join(""))
                        : 0 < t
                        ? this._controls.$absolute.append(new Array(1 + t).join(this._templates[0]))
                        : t < 0 && this._controls.$absolute.children().slice(t).remove(),
                    this._controls.$absolute.find(".active").removeClass("active"),
                    this._controls.$absolute.children().eq(o.inArray(this.current(), this._pages)).addClass("active"));
        }),
        (e.prototype.onTrigger = function (t) {
            var e = this._core.settings;
            t.page = { index: o.inArray(this.current(), this._pages), count: this._pages.length, size: e && (e.center || e.autoWidth || e.dotsData ? 1 : e.dotsEach || e.items) };
        }),
        (e.prototype.current = function () {
            var i = this._core.relative(this._core.current());
            return o
                .grep(
                    this._pages,
                    o.proxy(function (t, e) {
                        return t.start <= i && t.end >= i;
                    }, this)
                )
                .pop();
        }),
        (e.prototype.getPosition = function (t) {
            var e,
                i,
                n = this._core.settings;
            return (
                "page" == n.slideBy
                    ? ((e = o.inArray(this.current(), this._pages)), (i = this._pages.length), t ? ++e : --e, (e = this._pages[((e % i) + i) % i].start))
                    : ((e = this._core.relative(this._core.current())), (i = this._core.items().length), t ? (e += n.slideBy) : (e -= n.slideBy)),
                e
            );
        }),
        (e.prototype.next = function (t) {
            o.proxy(this._overrides.to, this._core)(this.getPosition(!0), t);
        }),
        (e.prototype.prev = function (t) {
            o.proxy(this._overrides.to, this._core)(this.getPosition(!1), t);
        }),
        (e.prototype.to = function (t, e, i) {
            var n;
            !i && this._pages.length ? ((n = this._pages.length), o.proxy(this._overrides.to, this._core)(this._pages[((t % n) + n) % n].start, e)) : o.proxy(this._overrides.to, this._core)(t, e);
        }),
        (o.fn.owlCarousel.Constructor.Plugins.Navigation = e);
})(window.Zepto || window.jQuery, window, document),
(function (n, s) {
    "use strict";
    var e = function (t) {
        (this._core = t),
            (this._hashes = {}),
            (this.$element = this._core.$element),
            (this._handlers = {
                "initialized.owl.carousel": n.proxy(function (t) {
                    t.namespace && "URLHash" === this._core.settings.startPosition && n(s).trigger("hashchange.owl.navigation");
                }, this),
                "prepared.owl.carousel": n.proxy(function (t) {
                    if (t.namespace) {
                        var e = n(t.content).find("[data-hash]").addBack("[data-hash]").attr("data-hash");
                        if (!e) return;
                        this._hashes[e] = t.content;
                    }
                }, this),
                "changed.owl.carousel": n.proxy(function (t) {
                    if (t.namespace && "position" === t.property.name) {
                        var i = this._core.items(this._core.relative(this._core.current())),
                            e = n
                                .map(this._hashes, function (t, e) {
                                    return t === i ? e : null;
                                })
                                .join();
                        if (!e || s.location.hash.slice(1) === e) return;
                        s.location.hash = e;
                    }
                }, this),
            }),
            (this._core.options = n.extend({}, e.Defaults, this._core.options)),
            this.$element.on(this._handlers),
            n(s).on(
                "hashchange.owl.navigation",
                n.proxy(function (t) {
                    var e = s.location.hash.substring(1),
                        i = this._core.$stage.children(),
                        n = this._hashes[e] && i.index(this._hashes[e]);
                    void 0 !== n && n !== this._core.current() && this._core.to(this._core.relative(n), !1, !0);
                }, this)
            );
    };
    (e.Defaults = { URLhashListener: !1 }),
        (e.prototype.destroy = function () {
            var t, e;
            for (t in (n(s).off("hashchange.owl.navigation"), this._handlers)) this._core.$element.off(t, this._handlers[t]);
            for (e in Object.getOwnPropertyNames(this)) "function" != typeof this[e] && (this[e] = null);
        }),
        (n.fn.owlCarousel.Constructor.Plugins.Hash = e);
})(jQuery)