!function(a) {
    function b() {
        return new Date(Date.UTC.apply(Date, arguments))
    }
    var c = function(b, c) {
        var f = this;
        this.element = a(b),
        this.autoShow = c.autoShow || !0,
        this.appendTo = c.appendTo || "body",
        this.closeButton = c.closeButton,
        this.language = c.language || this.element.data("date-language") || "en",
        this.language = this.language in d ? this.language : this.language.split("-")[0],
        this.language = this.language in d ? this.language : "en",
        this.isRTL = d[this.language].rtl || !1,
        this.format = e.parseFormat(c.format || this.element.data("date-format") || d[this.language].format || "mm/dd/yyyy"),
        this.isInline = !1,
        this.onlyone = 1,
        this.isInput = this.element.is("input"),
        this.component = this.element.is(".date") ? this.element.find(".prefix, .postfix") : !1,
        this.hasInput = this.component && this.element.find("input").length,
        this.disableDblClickSelection = c.disableDblClickSelection,
        this.onRender = c.onRender || function() {}
        ,
        this.component && 0 === this.component.length && (this.component = !1),
        this.linkField = c.linkField || this.element.data("link-field") || !1,
        this.linkFormat = e.parseFormat(c.linkFormat || this.element.data("link-format") || "yyyy-mm-dd hh:ii:ss"),
        this.minuteStep = c.minuteStep || this.element.data("minute-step") || 5,
        this.pickerPosition = c.pickerPosition || this.element.data("picker-position") || "bottom-right",
        this.initialDate = c.initialDate || null ,
        this._attachEvents(),
        this.minView = 0,
        "minView"in c ? this.minView = c.minView : "minView"in this.element.data() && (this.minView = this.element.data("min-view")),
        this.minView = e.convertViewMode(this.minView),
        this.maxView = e.modes.length - 1,
        "maxView"in c ? this.maxView = c.maxView : "maxView"in this.element.data() && (this.maxView = this.element.data("max-view")),
        this.maxView = e.convertViewMode(this.maxView),
        this.startViewMode = "month",
        "startView"in c ? this.startViewMode = c.startView : "startView"in this.element.data() && (this.startViewMode = this.element.data("start-view")),
        this.startViewMode = e.convertViewMode(this.startViewMode),
        this.viewMode = this.startViewMode,
        "minView"in c || "maxView"in c || this.element.data("min-view") && !this.element.data("max-view") || (this.pickTime = !1,
        "pickTime"in c && (this.pickTime = c.pickTime),
        1 == this.pickTime ? (this.minView = 0,
        this.maxView = 4) : (this.minView = 2,
        this.maxView = 4)),
        this.forceParse = !0,
        "forceParse"in c ? this.forceParse = c.forceParse : "dateForceParse"in this.element.data() && (this.forceParse = this.element.data("date-force-parse")),
        this.exist = a(".datepicker").size() > 0,
        
        this.picker = this.exist ? (this.onlyone ? a(".datepicker") : a(e.template).appendTo(this.isInline ? this.element : this.appendTo)) : a(e.template).appendTo(this.isInline ? this.element : this.appendTo),
        this.picker.on({
            click: a.proxy(this.click, this),
            mousedown: a.proxy(this.mousedown, this)
        }),
        /*
        this.picker = a(e.template).appendTo(this.isInline ? this.element : this.appendTo).on({
            click: a.proxy(this.click, this),
            mousedown: a.proxy(this.mousedown, this)
        }),
        */
        this.closeButton ? this.picker.find("a.datepicker-close").show() : this.picker.find("a.datepicker-close").hide(),
        this.isInline ? this.picker.addClass("datepicker-inline") : this.picker.addClass("datepicker-dropdown dropdown-menu"),
        this.isRTL && (this.picker.addClass("datepicker-rtl"),
        this.picker.find(".prev i, .next i").toggleClass("fa-chevron-left fa-chevron-right")),
        a(document).on("mousedown", function(b) {
            0 === a(b.target).closest(".datepicker.datepicker-inline, .datepicker.datepicker-dropdown").length && f.hide()
        }),
        this.autoclose = !0,
        "autoclose"in c ? this.autoclose = c.autoclose : "dateAutoclose"in this.element.data() && (this.autoclose = this.element.data("date-autoclose")),
        this.keyboardNavigation = !0,
        "keyboardNavigation"in c ? this.keyboardNavigation = c.keyboardNavigation : "dateKeyboardNavigation"in this.element.data() && (this.keyboardNavigation = this.element.data("date-keyboard-navigation")),
        this.todayBtn = c.todayBtn || this.element.data("date-today-btn") || !1,
        this.todayHighlight = c.todayHighlight || this.element.data("date-today-highlight") || !1,
        this.calendarWeeks = !1,
        "calendarWeeks"in c ? this.calendarWeeks = c.calendarWeeks : "dateCalendarWeeks"in this.element.data() && (this.calendarWeeks = this.element.data("date-calendar-weeks")),
        this.calendarWeeks && this.picker.find("tfoot th.today").attr("colspan", function(a, b) {
            return parseInt(b) + 1
        }),
        this.weekStart = (c.weekStart || this.element.data("date-weekstart") || d[this.language].weekStart || 0) % 7,
        this.weekEnd = (this.weekStart + 6) % 7,
        this.startDate = -(1 / 0),
        this.endDate = 1 / 0,
        this.daysOfWeekDisabled = [],
        this.setStartDate(c.startDate || this.element.data("date-startdate")),
        this.setEndDate(c.endDate || this.element.data("date-enddate")),
        this.setDaysOfWeekDisabled(c.daysOfWeekDisabled || this.element.data("date-days-of-week-disabled"));
        if(!this.exist) {
	        this.fillDow(),
	        this.fillMonths(),
	        this.update(),
	        this.showMode();
	      }
	      this.isInline && this.show();
    }
    ;
    c.prototype = {
        constructor: c,
        _events: [],
        _attachEvents: function() {
            this._detachEvents(),
            this.isInput ? this._events = [[this.element, {
                focus: this.autoShow ? a.proxy(this.show, this) : function() {}
                ,
                keyup: a.proxy(this.update, this),
                keydown: a.proxy(this.keydown, this)
            }]] : this.component && this.hasInput ? this._events = [[this.element.find("input"), {
                focus: this.autoShow ? a.proxy(this.show, this) : function() {}
                ,
                keyup: a.proxy(this.update, this),
                keydown: a.proxy(this.keydown, this)
            }], [this.component, {
                click: a.proxy(this.show, this)
            }]] : this.element.is("div") ? this.isInline = !0 : this._events = [[this.element, {
                click: a.proxy(this.show, this)
            }]],
            this.disableDblClickSelection && (this._events[this._events.length] = [this.element, {
                dblclick: function(b) {
                    b.preventDefault(),
                    b.stopPropagation(),
                    a(this).blur()
                }
            }]);
            for (var b, c, d = 0; d < this._events.length; d++)
                b = this._events[d][0],
                c = this._events[d][1],
                b.on(c)
        },
        _detachEvents: function() {
            for (var a, b, c = 0; c < this._events.length; c++)
                a = this._events[c][0],
                b = this._events[c][1],
                a.off(b);
            this._events = []
        },
        show: function(b) {
            this.picker.show(),
            this.height = this.component ? this.component.outerHeight() : this.element.outerHeight(),
            this.update(),
            this.place(),
            a(window).on("resize", a.proxy(this.place, this)),
            b && (b.stopPropagation(),
            b.preventDefault()),
            this.element.trigger({
                type: "show",
                date: this.date
            })
        },
        hide: function(b) {
            this.isInline || this.picker.is(":visible") && (this.picker.hide(),
            a(window).off("resize", this.place),
            this.viewMode = this.startViewMode,
            this.showMode(),
            this.isInput || a(document).off("mousedown", this.hide),
            this.forceParse && (this.isInput && this.element.val() || this.hasInput && this.element.find("input").val()) && this.setValue(),
            this.element.trigger({
                type: "hide",
                date: this.date
            }))
        },
        remove: function() {
            this._detachEvents(),
            this.picker.remove(),
            delete this.element.data().datepicker
        },
        getDate: function() {
            var a = this.getUTCDate();
            return new Date(a.getTime() + 6e4 * a.getTimezoneOffset())
        },
        getUTCDate: function() {
            return this.date
        },
        setDate: function(a) {
            this.setUTCDate(new Date(a.getTime() - 6e4 * a.getTimezoneOffset()))
        },
        setUTCDate: function(a) {
            this.date = a,
            this.setValue()
        },
        setValue: function() {
            var a = this.getFormattedDate();
            this.isInput ? this.element.val(a) : (this.component && this.element.find("input").val(a),
            this.element.data("date", a))
        },
        getFormattedDate: function(a) {
            return void 0 === a && (a = this.format),
            e.formatDate(this.date, a, this.language)
        },
        setStartDate: function(a) {
            this.startDate = a || -(1 / 0),
            this.startDate !== -(1 / 0) && (this.startDate = e.parseDate(this.startDate, this.format, this.language)),
            this.update(),
            this.updateNavArrows()
        },
        setEndDate: function(a) {
            this.endDate = a || 1 / 0,
            this.endDate !== 1 / 0 && (this.endDate = e.parseDate(this.endDate, this.format, this.language)),
            this.update(),
            this.updateNavArrows()
        },
        setDaysOfWeekDisabled: function(b) {
            this.daysOfWeekDisabled = b || [],
            a.isArray(this.daysOfWeekDisabled) || (this.daysOfWeekDisabled = this.daysOfWeekDisabled.split(/,\s*/)),
            this.daysOfWeekDisabled = a.map(this.daysOfWeekDisabled, function(a) {
                return parseInt(a, 10)
            }),
            this.update(),
            this.updateNavArrows()
        },
        place: function() {
            if (!this.isInline) {
                var b = parseInt(this.element.parents().filter(function() {
                    return "auto" != a(this).css("z-index")
                }).first().css("z-index")) + 10
                  , c = this.component ? this.component : this.element
                  , d = c.offset()
                  , e = c.outerHeight() + parseInt(c.css("margin-top"))
                  , f = c.outerWidth() + parseInt(c.css("margin-left"))
                  , g = d.top + e
                  , h = d.left;
                g + this.picker.outerHeight() >= a(window).scrollTop() + a(window).height() && (g = d.top - this.picker.outerHeight()),
                d.left + this.picker.width() >= a(window).width() && (h = d.left + f - this.picker.width()),
                this.picker.css({
                    top: g,
                    left: h,
                    zIndex: b
                })
            }
        },
        update: function() {
            var a, b = !1, c = this.isInput ? this.element.val() : this.element.data("date") || this.element.find("input").val();
            arguments && arguments.length && ("string" == typeof arguments[0] || arguments[0]instanceof Date) ? (a = arguments[0],
            b = !0) : a = c || null == this.initialDate ? this.isInput ? this.element.val() : this.element.data("date") || this.element.find("input").val() : this.initialDate,
            this.date = e.parseDate(a, this.format, this.language),
            (b || null != this.initialDate) && this.setValue(),
            this.date < this.startDate ? this.viewDate = new Date(this.startDate.valueOf()) : this.date > this.endDate ? this.viewDate = new Date(this.endDate.valueOf()) : this.viewDate = new Date(this.date.valueOf()),
            this.fill()
        },
        fillDow: function() {
            var a = this.weekStart
              , b = "<tr>";
            if (this.calendarWeeks) {
                var c = '<th class="cw">&nbsp;</th>';
                b += c,
                this.picker.find(".datepicker-days thead tr:first-child").prepend(c)
            }
            for (; a < this.weekStart + 7; )
                b += '<th class="dow">' + d[this.language].daysMin[a++ % 7] + "</th>";
            b += "</tr>",
            this.picker.find(".datepicker-days thead").append(b)
        },
        fillMonths: function() {
            for (var a = "", b = 0; 12 > b; )
                a += '<span class="month">' + d[this.language].monthsShort[b++] + "</span>";
            this.picker.find(".datepicker-months td").html(a)
        },
        fill: function() {
            if (null != this.date && null != this.viewDate) {
                var c = new Date(this.viewDate.valueOf())
                  , f = c.getUTCFullYear()
                  , g = c.getUTCMonth()
                  , h = c.getUTCDate()
                  , i = c.getUTCHours()
                  , j = c.getUTCMinutes()
                  , k = this.startDate !== -(1 / 0) ? this.startDate.getUTCFullYear() : -(1 / 0)
                  , l = this.startDate !== -(1 / 0) ? this.startDate.getUTCMonth() : -(1 / 0)
                  , m = this.endDate !== 1 / 0 ? this.endDate.getUTCFullYear() : 1 / 0
                  , n = this.endDate !== 1 / 0 ? this.endDate.getUTCMonth() : 1 / 0
                  , o = this.date && this.date.valueOf()
                  , p = new Date;
                d[this.language].titleFormat || d.en.titleFormat;
                this.picker.find(".datepicker-days thead th:eq(1)").text(d[this.language].months[g] + " " + f),
                this.picker.find(".datepicker-hours thead th:eq(1)").text(h + " " + d[this.language].months[g] + " " + f),
                this.picker.find(".datepicker-minutes thead th:eq(1)").text(h + " " + d[this.language].months[g] + " " + f),
                this.picker.find("tfoot th.today").text(d[this.language].today).toggle(this.todayBtn !== !1),
                this.updateNavArrows(),
                this.fillMonths();
                var q = b(f, g - 1, 28, 0, 0, 0, 0)
                  , r = e.getDaysInMonth(q.getUTCFullYear(), q.getUTCMonth());
                q.setUTCDate(r),
                q.setUTCDate(r - (q.getUTCDay() - this.weekStart + 7) % 7);
                var s = new Date(q.valueOf());
                s.setUTCDate(s.getUTCDate() + 42),
                s = s.valueOf();
                for (var t, u = []; q.valueOf() < s; ) {
                    if (q.getUTCDay() == this.weekStart && (u.push("<tr>"),
                    this.calendarWeeks)) {
                        var v = new Date(q.getUTCFullYear(),q.getUTCMonth(),q.getUTCDate() - q.getDay() + 10 - (this.weekStart && this.weekStart % 7 < 5 && 7))
                          , w = new Date(v.getFullYear(),0,4)
                          , x = ~~((v - w) / 864e5 / 7 + 1.5);
                        u.push('<td class="cw">' + x + "</td>")
                    }
                    t = " " + this.onRender(q) + " ",
                    q.getUTCFullYear() < f || q.getUTCFullYear() == f && q.getUTCMonth() < g ? t += " old" : (q.getUTCFullYear() > f || q.getUTCFullYear() == f && q.getUTCMonth() > g) && (t += " new"),
                    this.todayHighlight && q.getUTCFullYear() == p.getFullYear() && q.getUTCMonth() == p.getMonth() && q.getUTCDate() == p.getDate() && (t += " today"),
                    o && q.valueOf() == o && (t += " active"),
                    (q.valueOf() < this.startDate || q.valueOf() > this.endDate || -1 !== a.inArray(q.getUTCDay(), this.daysOfWeekDisabled)) && (t += " disabled"),
                    u.push('<td class="day' + t + '">' + q.getUTCDate() + "</td>"),
                    q.getUTCDay() == this.weekEnd && u.push("</tr>"),
                    q.setUTCDate(q.getUTCDate() + 1)
                }
                this.picker.find(".datepicker-days tbody").empty().append(u.join("")),
                u = [];
                for (var y = 0; 24 > y; y++) {
                    var z = b(f, g, h, y);
                    t = "",
                    z.valueOf() + 36e5 < this.startDate || z.valueOf() > this.endDate ? t += " disabled" : i == y && (t += " active"),
                    u.push('<span class="hour' + t + '">' + y + ":00</span>")
                }
                this.picker.find(".datepicker-hours td").html(u.join("")),
                u = [];
                for (var y = 0; 60 > y; y += this.minuteStep) {
                    var z = b(f, g, h, i, y);
                    t = "",
                    z.valueOf() < this.startDate || z.valueOf() > this.endDate ? t += " disabled" : Math.floor(j / this.minuteStep) == Math.floor(y / this.minuteStep) && (t += " active"),
                    u.push('<span class="minute' + t + '">' + i + ":" + (10 > y ? "0" + y : y) + "</span>")
                }
                this.picker.find(".datepicker-minutes td").html(u.join(""));
                var A = this.date && this.date.getUTCFullYear()
                  , B = this.picker.find(".datepicker-months").find("th:eq(1)").text(f).end().find("span").removeClass("active");
                A && A == f && B.eq(this.date.getUTCMonth()).addClass("active"),
                (k > f || f > m) && B.addClass("disabled"),
                f == k && B.slice(0, l).addClass("disabled"),
                f == m && B.slice(n + 1).addClass("disabled"),
                u = "",
                f = 10 * parseInt(f / 10, 10);
                var C = this.picker.find(".datepicker-years").find("th:eq(1)").text(f + "-" + (f + 9)).end().find("td");
                f -= 1;
                for (var y = -1; 11 > y; y++)
                    u += '<span class="year' + (-1 == y || 10 == y ? " old" : "") + (A == f ? " active" : "") + (k > f || f > m ? " disabled" : "") + '">' + f + "</span>",
                    f += 1;
                C.html(u)
            }
        },
        updateNavArrows: function() {
            var a = new Date(this.viewDate)
              , b = a.getUTCFullYear()
              , c = a.getUTCMonth()
              , d = a.getUTCDate()
              , e = a.getUTCHours();
            switch (this.viewMode) {
            case 0:
                this.startDate !== -(1 / 0) && b <= this.startDate.getUTCFullYear() && c <= this.startDate.getUTCMonth() && d <= this.startDate.getUTCDate() && e <= this.startDate.getUTCHours() ? this.picker.find(".prev").css({
                    visibility: "hidden"
                }) : this.picker.find(".prev").css({
                    visibility: "visible"
                }),
                this.endDate !== 1 / 0 && b >= this.endDate.getUTCFullYear() && c >= this.endDate.getUTCMonth() && d >= this.endDate.getUTCDate() && e >= this.endDate.getUTCHours() ? this.picker.find(".next").css({
                    visibility: "hidden"
                }) : this.picker.find(".next").css({
                    visibility: "visible"
                });
                break;
            case 1:
                this.startDate !== -(1 / 0) && b <= this.startDate.getUTCFullYear() && c <= this.startDate.getUTCMonth() && d <= this.startDate.getUTCDate() ? this.picker.find(".prev").css({
                    visibility: "hidden"
                }) : this.picker.find(".prev").css({
                    visibility: "visible"
                }),
                this.endDate !== 1 / 0 && b >= this.endDate.getUTCFullYear() && c >= this.endDate.getUTCMonth() && d >= this.endDate.getUTCDate() ? this.picker.find(".next").css({
                    visibility: "hidden"
                }) : this.picker.find(".next").css({
                    visibility: "visible"
                });
                break;
            case 2:
                this.startDate !== -(1 / 0) && b <= this.startDate.getUTCFullYear() && c <= this.startDate.getUTCMonth() ? this.picker.find(".prev").css({
                    visibility: "hidden"
                }) : this.picker.find(".prev").css({
                    visibility: "visible"
                }),
                this.endDate !== 1 / 0 && b >= this.endDate.getUTCFullYear() && c >= this.endDate.getUTCMonth() ? this.picker.find(".next").css({
                    visibility: "hidden"
                }) : this.picker.find(".next").css({
                    visibility: "visible"
                });
                break;
            case 3:
            case 4:
                this.startDate !== -(1 / 0) && b <= this.startDate.getUTCFullYear() ? this.picker.find(".prev").css({
                    visibility: "hidden"
                }) : this.picker.find(".prev").css({
                    visibility: "visible"
                }),
                this.endDate !== 1 / 0 && b >= this.endDate.getUTCFullYear() ? this.picker.find(".next").css({
                    visibility: "hidden"
                }) : this.picker.find(".next").css({
                    visibility: "visible"
                })
            }
        },
        click: function(c) {
            c.stopPropagation(),
            c.preventDefault(),
            (a(c.target).hasClass("datepicker-close") || a(c.target).parent().hasClass("datepicker-close")) && this.hide();
            var d = a(c.target).closest("span, td, th");
            if (1 == d.length) {
                if (d.is(".disabled"))
                    return void this.element.trigger({
                        type: "outOfRange",
                        date: this.viewDate,
                        startDate: this.startDate,
                        endDate: this.endDate
                    });
                switch (d[0].nodeName.toLowerCase()) {
                case "th":
                    switch (d[0].className) {
                    case "date-switch":
                        this.showMode(1);
                        break;
                    case "prev":
                    case "next":
                        var f = e.modes[this.viewMode].navStep * ("prev" == d[0].className ? -1 : 1);
                        switch (this.viewMode) {
                        case 0:
                            this.viewDate = this.moveHour(this.viewDate, f);
                            break;
                        case 1:
                            this.viewDate = this.moveDate(this.viewDate, f);
                            break;
                        case 2:
                            this.viewDate = this.moveMonth(this.viewDate, f);
                            break;
                        case 3:
                        case 4:
                            this.viewDate = this.moveYear(this.viewDate, f)
                        }
                        this.fill();
                        break;
                    case "today":
                        var g = new Date;
                        g = b(g.getFullYear(), g.getMonth(), g.getDate(), g.getHours(), g.getMinutes(), g.getSeconds()),
                        this.viewMode = this.startViewMode,
                        this.showMode(0),
                        this._setDate(g)
                    }
                    break;
                case "span":
                    if (!d.is(".disabled")) {
                        if (d.is(".month"))
                            if (3 === this.minView) {
                                var h = d.parent().find("span").index(d) || 0
                                  , i = this.viewDate.getUTCFullYear()
                                  , j = 1
                                  , k = this.viewDate.getUTCHours()
                                  , l = this.viewDate.getUTCMinutes()
                                  , m = this.viewDate.getUTCSeconds();
                                this._setDate(b(i, h, j, k, l, m, 0))
                            } else {
                                this.viewDate.setUTCDate(1);
                                var h = d.parent().find("span").index(d);
                                this.viewDate.setUTCMonth(h),
                                this.element.trigger({
                                    type: "changeMonth",
                                    date: this.viewDate
                                })
                            }
                        else if (d.is(".year"))
                            if (4 === this.minView) {
                                var i = parseInt(d.text(), 10) || 0
                                  , h = 0
                                  , j = 1
                                  , k = this.viewDate.getUTCHours()
                                  , l = this.viewDate.getUTCMinutes()
                                  , m = this.viewDate.getUTCSeconds();
                                this._setDate(b(i, h, j, k, l, m, 0))
                            } else {
                                this.viewDate.setUTCDate(1);
                                var i = parseInt(d.text(), 10) || 0;
                                this.viewDate.setUTCFullYear(i),
                                this.element.trigger({
                                    type: "changeYear",
                                    date: this.viewDate
                                })
                            }
                        else if (d.is(".hour")) {
                            var k = parseInt(d.text(), 10) || 0
                              , i = this.viewDate.getUTCFullYear()
                              , h = this.viewDate.getUTCMonth()
                              , j = this.viewDate.getUTCDate()
                              , l = this.viewDate.getUTCMinutes()
                              , m = this.viewDate.getUTCSeconds();
                            this._setDate(b(i, h, j, k, l, m, 0))
                        } else if (d.is(".minute")) {
                            var l = parseInt(d.text().substr(d.text().indexOf(":") + 1), 10) || 0
                              , i = this.viewDate.getUTCFullYear()
                              , h = this.viewDate.getUTCMonth()
                              , j = this.viewDate.getUTCDate()
                              , k = this.viewDate.getUTCHours()
                              , m = this.viewDate.getUTCSeconds();
                            this._setDate(b(i, h, j, k, l, m, 0))
                        }
                        if (0 != this.viewMode) {
                            var n = this.viewMode;
                            this.showMode(-1),
                            this.fill(),
                            n == this.viewMode && this.autoclose && this.hide()
                        } else
                            this.fill(),
                            this.autoclose && this.hide()
                    }
                    break;
                case "td":
                    if (d.is(".day") && !d.is(".disabled")) {
                        var j = parseInt(d.text(), 10) || 1
                          , i = this.viewDate.getUTCFullYear()
                          , h = this.viewDate.getUTCMonth()
                          , k = this.viewDate.getUTCHours()
                          , l = this.viewDate.getUTCMinutes()
                          , m = this.viewDate.getUTCSeconds();
                        d.is(".old") ? 0 === h ? (h = 11,
                        i -= 1) : h -= 1 : d.is(".new") && (11 == h ? (h = 0,
                        i += 1) : h += 1),
                        this._setDate(b(i, h, j, k, l, m, 0))
                    }
                    var n = this.viewMode;
                    this.showMode(-1),
                    this.fill(),
                    n == this.viewMode && this.autoclose && this.hide()
                }
            }
        },
        _setDate: function(a, b) {
            b && "date" != b || (this.date = a),
            b && "view" != b || (this.viewDate = a),
            this.fill(),
            this.setValue(),
            this.element.trigger({
                type: "changeDate",
                date: this.date
            });
            var c;
            this.isInput ? c = this.element : this.component && (c = this.element.find("input")),
            c && (c.change(),
            this.autoclose && (!b || "date" == b))
        },
        moveHour: function(a, b) {
            if (!b)
                return a;
            var c = new Date(a.valueOf());
            return b = b > 0 ? 1 : -1,
            c.setUTCHours(c.getUTCHours() + b),
            c
        },
        moveDate: function(a, b) {
            if (!b)
                return a;
            var c = new Date(a.valueOf());
            return b = b > 0 ? 1 : -1,
            c.setUTCDate(c.getUTCDate() + b),
            c
        },
        moveMonth: function(a, b) {
            if (!b)
                return a;
            var c, d, e = new Date(a.valueOf()), f = e.getUTCDate(), g = e.getUTCMonth(), h = Math.abs(b);
            if (b = b > 0 ? 1 : -1,
            1 == h)
                d = -1 == b ? function() {
                    return e.getUTCMonth() == g
                }
                : function() {
                    return e.getUTCMonth() != c
                }
                ,
                c = g + b,
                e.setUTCMonth(c),
                (0 > c || c > 11) && (c = (c + 12) % 12);
            else {
                for (var i = 0; h > i; i++)
                    e = this.moveMonth(e, b);
                c = e.getUTCMonth(),
                e.setUTCDate(f),
                d = function() {
                    return c != e.getUTCMonth()
                }
            }
            for (; d(); )
                e.setUTCDate(--f),
                e.setUTCMonth(c);
            return e
        },
        moveYear: function(a, b) {
            return this.moveMonth(a, 12 * b)
        },
        dateWithinRange: function(a) {
            return a >= this.startDate && a <= this.endDate
        },
        keydown: function(a) {
            if (this.picker.is(":not(:visible)"))
                return void (27 == a.keyCode && this.show());
            var b, c, d, e = !1;
            switch (a.keyCode) {
            case 27:
                this.hide(),
                a.preventDefault();
                break;
            case 37:
            case 39:
                if (!this.keyboardNavigation)
                    break;
                b = 37 == a.keyCode ? -1 : 1,
                a.ctrlKey ? (c = this.moveYear(this.date, b),
                d = this.moveYear(this.viewDate, b)) : a.shiftKey ? (c = this.moveMonth(this.date, b),
                d = this.moveMonth(this.viewDate, b)) : (c = new Date(this.date.valueOf()),
                c.setUTCDate(this.date.getUTCDate() + b),
                d = new Date(this.viewDate.valueOf()),
                d.setUTCDate(this.viewDate.getUTCDate() + b)),
                this.dateWithinRange(c) && (this.date = c,
                this.viewDate = d,
                this.setValue(),
                this.update(),
                a.preventDefault(),
                e = !0);
                break;
            case 38:
            case 40:
                if (!this.keyboardNavigation)
                    break;
                b = 38 == a.keyCode ? -1 : 1,
                a.ctrlKey ? (c = this.moveYear(this.date, b),
                d = this.moveYear(this.viewDate, b)) : a.shiftKey ? (c = this.moveMonth(this.date, b),
                d = this.moveMonth(this.viewDate, b)) : (c = new Date(this.date.valueOf()),
                c.setUTCDate(this.date.getUTCDate() + 7 * b),
                d = new Date(this.viewDate.valueOf()),
                d.setUTCDate(this.viewDate.getUTCDate() + 7 * b)),
                this.dateWithinRange(c) && (this.date = c,
                this.viewDate = d,
                this.setValue(),
                this.update(),
                a.preventDefault(),
                e = !0);
                break;
            case 13:
                this.hide(),
                a.preventDefault();
                break;
            case 9:
                this.hide()
            }
            if (e) {
                this.element.trigger({
                    type: "changeDate",
                    date: this.date
                });
                var f;
                this.isInput ? f = this.element : this.component && (f = this.element.find("input")),
                f && f.change()
            }
        },
        showMode: function(a) {
            if (a) {
                var b = Math.max(0, Math.min(e.modes.length - 1, this.viewMode + a));
                b >= this.minView && b <= this.maxView && (this.viewMode = b)
            }
            this.picker.find(">div").hide().filter(".datepicker-" + e.modes[this.viewMode].clsName).css("display", "block"),
            this.updateNavArrows()
        },
        reset: function(a) {
            this._setDate(null , "date")
        }
    },
    a.fn.asrdatepicker = function(t, b) {
    	var d = Array.apply(null , arguments);
        var ds = d.shift(),
        e = a(this)
              , f = e.data("datepicker")
              , g = "object" == typeof b && b;
            f || e.data("datepicker", f = new c(this,a.extend({}, a.fn.fdatepicker.defaults, g))),
            "string" == typeof b && "function" == typeof f[b] && f[b].apply(f, d);
       return ds;
    },
    a.fn.fdatepicker = function(b) {
        var d = Array.apply(null , arguments);
        return d.shift(),
        this.each(function() {
            var e = a(this)
              , f = e.data("datepicker")
              , g = "object" == typeof b && b;
            f || e.data("datepicker", f = new c(this,a.extend({}, a.fn.fdatepicker.defaults, g))),
            "string" == typeof b && "function" == typeof f[b] && f[b].apply(f, d)
        })
    }
    ,
    a.fn.fdatepicker.defaults = {
        onRender: function(a) {
            return ""
        }
    },
    a.fn.fdatepicker.Constructor = c;
    var d = a.fn.fdatepicker.dates = {
        en: {
            days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
            daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
            daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
            months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            today: "Today",
            titleFormat: "MM yyyy"
        }
    }
      , e = {
        modes: [{
            clsName: "minutes",
            navFnc: "Hours",
            navStep: 1
        }, {
            clsName: "hours",
            navFnc: "Date",
            navStep: 1
        }, {
            clsName: "days",
            navFnc: "Month",
            navStep: 1
        }, {
            clsName: "months",
            navFnc: "FullYear",
            navStep: 1
        }, {
            clsName: "years",
            navFnc: "FullYear",
            navStep: 10
        }],
        isLeapYear: function(a) {
            return a % 4 === 0 && a % 100 !== 0 || a % 400 === 0
        },
        getDaysInMonth: function(a, b) {
            return [31, e.isLeapYear(a) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][b]
        },
        validParts: /hh?|ii?|ss?|dd?|mm?|MM?|yy(?:yy)?/g,
        nonpunctuation: /[^ -\/:-@\[\u3400-\u9fff-`{-~\t\n\r]+/g,
        parseFormat: function(a) {
            var b = a.replace(this.validParts, "\x00").split("\x00")
              , c = a.match(this.validParts);
            if (!b || !b.length || !c || 0 === c.length)
                throw new Error("Invalid date format.");
            return {
                separators: b,
                parts: c
            }
        },
        parseDate: function(c, e, f) {
            if (c instanceof Date)
                return new Date(c.valueOf() - 6e4 * c.getTimezoneOffset());
            if (/^\d{4}\-\d{1,2}\-\d{1,2}$/.test(c) && (e = this.parseFormat("yyyy-mm-dd")),
            /^\d{4}\-\d{1,2}\-\d{1,2}[T ]\d{1,2}\:\d{1,2}$/.test(c) && (e = this.parseFormat("yyyy-mm-dd hh:ii")),
            /^\d{4}\-\d{1,2}\-\d{1,2}[T ]\d{1,2}\:\d{1,2}\:\d{1,2}[Z]{0,1}$/.test(c) && (e = this.parseFormat("yyyy-mm-dd hh:ii:ss")),
            /^[-+]\d+[dmwy]([\s,]+[-+]\d+[dmwy])*$/.test(c)) {
                var g, h, i = /([-+]\d+)([dmwy])/, j = c.match(/([-+]\d+)([dmwy])/g);
                c = new Date;
                for (var k = 0; k < j.length; k++)
                    switch (g = i.exec(j[k]),
                    h = parseInt(g[1]),
                    g[2]) {
                    case "d":
                        c.setUTCDate(c.getUTCDate() + h);
                        break;
                    case "m":
                        c = Datetimepicker.prototype.moveMonth.call(Datetimepicker.prototype, c, h);
                        break;
                    case "w":
                        c.setUTCDate(c.getUTCDate() + 7 * h);
                        break;
                    case "y":
                        c = Datetimepicker.prototype.moveYear.call(Datetimepicker.prototype, c, h)
                    }
                return b(c.getUTCFullYear(), c.getUTCMonth(), c.getUTCDate(), c.getUTCHours(), c.getUTCMinutes(), c.getUTCSeconds())
            }
            var l, m, g, j = c && c.match(this.nonpunctuation) || [], c = new Date, n = {}, o = ["hh", "h", "ii", "i", "ss", "s", "yyyy", "yy", "M", "MM", "m", "mm", "d", "dd"], p = {
                hh: function(a, b) {
                    return a.setUTCHours(b)
                },
                h: function(a, b) {
                    return a.setUTCHours(b)
                },
                ii: function(a, b) {
                    return a.setUTCMinutes(b)
                },
                i: function(a, b) {
                    return a.setUTCMinutes(b)
                },
                ss: function(a, b) {
                    return a.setUTCSeconds(b)
                },
                s: function(a, b) {
                    return a.setUTCSeconds(b)
                },
                yyyy: function(a, b) {
                    return a.setUTCFullYear(b)
                },
                yy: function(a, b) {
                    return a.setUTCFullYear(2e3 + b)
                },
                m: function(a, b) {
                    for (b -= 1; 0 > b; )
                        b += 12;
                    for (b %= 12,
                    a.setUTCMonth(b); a.getUTCMonth() != b; )
                        a.setUTCDate(a.getUTCDate() - 1);
                    return a
                },
                d: function(a, b) {
                    return a.setUTCDate(b)
                }
            };
            if (p.M = p.MM = p.mm = p.m,
            p.dd = p.d,
            c = b(c.getFullYear(), c.getMonth(), c.getDate(), 0, 0, 0),
            j.length == e.parts.length) {
                for (var k = 0, q = e.parts.length; q > k; k++) {
                    if (l = parseInt(j[k], 10),
                    g = e.parts[k],
                    isNaN(l))
                        switch (g) {
                        case "MM":
                            m = a(d[f].months).filter(function() {
                                var a = this.slice(0, j[k].length)
                                  , b = j[k].slice(0, a.length);
                                return a == b
                            }),
                            l = a.inArray(m[0], d[f].months) + 1;
                            break;
                        case "M":
                            m = a(d[f].monthsShort).filter(function() {
                                var a = this.slice(0, j[k].length)
                                  , b = j[k].slice(0, a.length);
                                return a == b
                            }),
                            l = a.inArray(m[0], d[f].monthsShort) + 1
                        }
                    n[g] = l
                }
                for (var r, k = 0; k < o.length; k++)
                    r = o[k],
                    r in n && !isNaN(n[r]) && p[r](c, n[r])
            }
            return c
        },
        formatDate: function(b, c, e) {
            if (null == b)
                return "";
            var f = {
                h: b.getUTCHours(),
                i: b.getUTCMinutes(),
                s: b.getUTCSeconds(),
                d: b.getUTCDate(),
                m: b.getUTCMonth() + 1,
                M: d[e].monthsShort[b.getUTCMonth()],
                MM: d[e].months[b.getUTCMonth()],
                yy: b.getUTCFullYear().toString().substring(2),
                yyyy: b.getUTCFullYear()
            };
            f.hh = (f.h < 10 ? "0" : "") + f.h,
            f.ii = (f.i < 10 ? "0" : "") + f.i,
            f.ss = (f.s < 10 ? "0" : "") + f.s,
            f.dd = (f.d < 10 ? "0" : "") + f.d,
            f.mm = (f.m < 10 ? "0" : "") + f.m;
            for (var b = [], g = a.extend([], c.separators), h = 0, i = c.parts.length; i > h; h++)
                g.length && b.push(g.shift()),
                b.push(f[c.parts[h]]);
            return b.join("")
        },
        convertViewMode: function(a) {
            switch (a) {
            case 4:
            case "decade":
                a = 4;
                break;
            case 3:
            case "year":
                a = 3;
                break;
            case 2:
            case "month":
                a = 2;
                break;
            case 1:
            case "day":
                a = 1;
                break;
            case 0:
            case "hour":
                a = 0
            }
            return a
        },
        headTemplate: '<thead><tr><th class="prev"><i class="fa fa-chevron-left fi-arrow-left"/></th><th colspan="5" class="date-switch"></th><th class="next"><i class="fa fa-chevron-right fi-arrow-right"/></th></tr></thead>',
        contTemplate: '<tbody><tr><td colspan="7"></td></tr></tbody>',
        footTemplate: '<tfoot><tr><th colspan="7" class="today"></th></tr></tfoot>'
    };
    e.template = '<div class="datepicker"><div class="datepicker-minutes"><table class=" table-condensed">' + e.headTemplate + e.contTemplate + e.footTemplate + '</table></div><div class="datepicker-hours"><table class=" table-condensed">' + e.headTemplate + e.contTemplate + e.footTemplate + '</table></div><div class="datepicker-days"><table class=" table-condensed">' + e.headTemplate + "<tbody></tbody>" + e.footTemplate + '</table></div><div class="datepicker-months"><table class="table-condensed">' + e.headTemplate + e.contTemplate + e.footTemplate + '</table></div><div class="datepicker-years"><table class="table-condensed">' + e.headTemplate + e.contTemplate + e.footTemplate + '</table></div><a class="button datepicker-close tiny alert right" style="width:auto;"><i class="fa fa-remove fa-times fi-x"></i></a></div>',
    a.fn.fdatepicker.DPGlobal = e
}(window.jQuery);
