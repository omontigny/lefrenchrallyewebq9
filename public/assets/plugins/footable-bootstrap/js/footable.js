/*
 * FooTable v3 - FooTable is a jQuery plugin that aims to make HTML tables on smaller devices look awesome.
 * @version 3.1.4
 * @link http://fooplugins.com
 * @copyright Steven Usher & Brad Vincent 2015
 * @license Released under the GPLv3 license.
 */
! function(a, b) {
	window.console = window.console || {
	    log: function() {},
	    error: function() {}
	}, a.fn.footable = function(a, c) {
	    return a = a || {}, this.filter("table").each(function(d, e) {
		  b.init(e, a, c)
	    })
	};
	var c = {
	    events: []
	};
	b.__debug__ = JSON.parse(localStorage.getItem("footable_debug")) || !1, b.__debug_options__ = JSON.parse(localStorage.getItem("footable_debug_options")) || c, b.debug = function(d, e) {
	    return b.is["boolean"](d) ? (b.__debug__ = d, void(b.__debug__ ? (localStorage.setItem("footable_debug", JSON.stringify(b.__debug__)), b.__debug_options__ = a.extend(!0, {}, c, e || {}), b.is.hash(e) && localStorage.setItem("footable_debug_options", JSON.stringify(b.__debug_options__))) : (localStorage.removeItem("footable_debug"), localStorage.removeItem("footable_debug_options")))) : b.__debug__
	}, b.get = function(b) {
	    return a(b).first().data("__FooTable__")
	}, b.init = function(a, c, d) {
	    var e = b.get(a);
	    return e instanceof b.Table && e.destroy(), new b.Table(a, c, d)
	}, b.getRow = function(b) {
	    var c = a(b).closest("tr");
	    return c.hasClass("footable-detail-row") && (c = c.prev()), c.data("__FooTableRow__")
	}
  }(jQuery, FooTable = window.FooTable || {}),
  function(a) {
	var b = function() {
	    return !0
	};
	a.arr = {}, a.arr.each = function(b, c) {
	    if (a.is.array(b) && a.is.fn(c))
		  for (var d = 0, e = b.length; e > d && c(b[d], d) !== !1; d++);
	}, a.arr.get = function(b, c) {
	    var d = [];
	    if (!a.is.array(b)) return d;
	    if (!a.is.fn(c)) return b;
	    for (var e = 0, f = b.length; f > e; e++) c(b[e], e) && d.push(b[e]);
	    return d
	}, a.arr.any = function(c, d) {
	    if (!a.is.array(c)) return !1;
	    d = a.is.fn(d) ? d : b;
	    for (var e = 0, f = c.length; f > e; e++)
		  if (d(c[e], e)) return !0;
	    return !1
	}, a.arr.contains = function(b, c) {
	    if (!a.is.array(b) || a.is.undef(c)) return !1;
	    for (var d = 0, e = b.length; e > d; d++)
		  if (b[d] == c) return !0;
	    return !1
	}, a.arr.first = function(c, d) {
	    if (!a.is.array(c)) return null;
	    d = a.is.fn(d) ? d : b;
	    for (var e = 0, f = c.length; f > e; e++)
		  if (d(c[e], e)) return c[e];
	    return null
	}, a.arr.map = function(b, c) {
	    var d = [],
		  e = null;
	    if (!a.is.array(b) || !a.is.fn(c)) return d;
	    for (var f = 0, g = b.length; g > f; f++) null != (e = c(b[f], f)) && d.push(e);
	    return d
	}, a.arr.remove = function(b, c) {
	    var d = [],
		  e = [];
	    if (!a.is.array(b) || !a.is.fn(c)) return e;
	    for (var f = 0, g = b.length; g > f; f++) c(b[f], f, e) && (d.push(f), e.push(b[f]));
	    for (d.sort(function(a, b) {
			return b - a
		  }), f = 0, g = d.length; g > f; f++) {
		  var h = d[f] - f;
		  b.splice(h, 1)
	    }
	    return e
	}, a.arr["delete"] = function(b, c) {
	    var d = -1,
		  e = null;
	    if (!a.is.array(b) || a.is.undef(c)) return e;
	    for (var f = 0, g = b.length; g > f; f++)
		  if (b[f] == c) {
			d = f, e = b[f];
			break
		  }
	    return -1 != d && b.splice(d, 1), e
	}, a.arr.replace = function(a, b, c) {
	    var d = a.indexOf(b); - 1 !== d && (a[d] = c)
	}
  }(FooTable),
  function(a) {
	a.is = {}, a.is.type = function(a, b) {
	    return typeof a === b
	}, a.is.defined = function(a) {
	    return "undefined" != typeof a
	}, a.is.undef = function(a) {
	    return "undefined" == typeof a
	}, a.is.array = function(a) {
	    return "[object Array]" === Object.prototype.toString.call(a)
	}, a.is.date = function(a) {
	    return "[object Date]" === Object.prototype.toString.call(a) && !isNaN(a.getTime())
	}, a.is["boolean"] = function(a) {
	    return "[object Boolean]" === Object.prototype.toString.call(a)
	}, a.is.string = function(a) {
	    return "[object String]" === Object.prototype.toString.call(a)
	}, a.is.number = function(a) {
	    return "[object Number]" === Object.prototype.toString.call(a) && !isNaN(a)
	}, a.is.fn = function(b) {
	    return a.is.defined(window) && b === window.alert || "[object Function]" === Object.prototype.toString.call(b)
	}, a.is.error = function(a) {
	    return "[object Error]" === Object.prototype.toString.call(a)
	}, a.is.object = function(a) {
	    return "[object Object]" === Object.prototype.toString.call(a)
	}, a.is.hash = function(b) {
	    return a.is.object(b) && b.constructor === Object && !b.nodeType && !b.setInterval
	}, a.is.element = function(a) {
	    return "object" == typeof HTMLElement ? a instanceof HTMLElement : a && "object" == typeof a && null !== a && 1 === a.nodeType && "string" == typeof a.nodeName
	}, a.is.promise = function(b) {
	    return a.is.object(b) && a.is.fn(b.then) && a.is.fn(b.promise)
	}, a.is.jq = function(b) {
	    return a.is.defined(window.jQuery) && b instanceof jQuery && b.length > 0
	}, a.is.moment = function(b) {
	    return a.is.defined(window.moment) && a.is.object(b) && a.is["boolean"](b._isAMomentObject)
	}, a.is.emptyObject = function(b) {
	    if (!a.is.hash(b)) return !1;
	    for (var c in b)
		  if (b.hasOwnProperty(c)) return !1;
	    return !0
	}, a.is.emptyArray = function(b) {
	    return a.is.array(b) ? 0 === b.length : !0
	}, a.is.emptyString = function(b) {
	    return a.is.string(b) ? 0 === b.length : !0
	}
  }(FooTable),
  function(a) {
	a.str = {}, a.str.contains = function(b, c, d) {
	    return a.is.emptyString(b) || a.is.emptyString(c) ? !1 : c.length <= b.length && -1 !== (d ? b.toUpperCase().indexOf(c.toUpperCase()) : b.indexOf(c))
	}, a.str.containsExact = function(b, c, d) {
	    return a.is.emptyString(b) || a.is.emptyString(c) || c.length > b.length ? !1 : new RegExp("\\b" + a.str.escapeRegExp(c) + "\\b", d ? "i" : "").test(b)
	}, a.str.containsWord = function(b, c, d) {
	    if (a.is.emptyString(b) || a.is.emptyString(c) || b.length < c.length) return !1;
	    for (var e = b.split(/\W/), f = 0, g = e.length; g > f; f++)
		  if (d ? e[f].toUpperCase() == c.toUpperCase() : e[f] == c) return !0;
	    return !1
	}, a.str.from = function(b, c) {
	    return a.is.emptyString(b) ? b : a.str.contains(b, c) ? b.substring(b.indexOf(c) + 1) : b
	}, a.str.startsWith = function(b, c) {
	    return a.is.emptyString(b) ? b == c : b.slice(0, c.length) == c
	}, a.str.toCamelCase = function(b) {
	    return a.is.emptyString(b) ? b : b.toUpperCase() === b ? b.toLowerCase() : b.replace(/^([A-Z])|[-\s_](\w)/g, function(b, c, d) {
		  return a.is.string(d) ? d.toUpperCase() : c.toLowerCase()
	    })
	}, a.str.random = function(b) {
	    return b = a.is.emptyString(b) ? "" : b, b + Math.random().toString(36).substr(2, 9)
	}, a.str.escapeRegExp = function(b) {
	    return a.is.emptyString(b) ? b : b.replace(/[.*+?^${}()|[\]\\]/g, "\\$&")
	}
  }(FooTable),
  function(a) {
	"use strict";
  
	function b() {}
	Object.create || (Object.create = function() {
	    var b = function() {};
	    return function(c) {
		  if (arguments.length > 1) throw Error("Second argument not supported");
		  if (!a.is.object(c)) throw TypeError("Argument must be an object");
		  b.prototype = c;
		  var d = new b;
		  return b.prototype = null, d
	    }
	}());
	var c = /xyz/.test(function() {
	    xyz
	}) ? /\b_super\b/ : /.*/;
	b.__extend__ = function(b, d, e, f) {
	    b[d] = a.is.fn(f) && c.test(e) ? function(a, b) {
		  return function() {
			var a, c;
			return a = this._super, this._super = f, c = b.apply(this, arguments), this._super = a, c
		  }
	    }(d, e) : e
	}, b.extend = function(d, e) {
	    function f(b, d, e, f) {
		  b[d] = a.is.fn(f) && c.test(e) ? function(a, b, c) {
			return function() {
			    var a, d;
			    return a = this._super, this._super = c, d = b.apply(this, arguments), this._super = a, d
			}
		  }(d, e, f) : e
	    }
	    var g = Array.prototype.slice.call(arguments);
	    if (d = g.shift(), e = g.shift(), a.is.hash(d)) {
		  var h = Object.create(this.prototype),
			i = this.prototype;
		  for (var j in d) "__ctor__" !== j && f(h, j, d[j], i[j]);
		  var k = a.is.fn(h.__ctor__) ? h.__ctor__ : function() {
			if (!a.is.fn(this.construct)) throw new SyntaxError('FooTable class objects must be constructed with the "new" keyword.');
			this.construct.apply(this, arguments)
		  };
		  return h.construct = a.is.fn(h.construct) ? h.construct : function() {}, k.prototype = h, h.constructor = k, k.extend = b.extend, k
	    }
	    a.is.string(d) && a.is.fn(e) && f(this.prototype, d, e, this.prototype[d])
	}, a.Class = b, a.ClassFactory = a.Class.extend({
	    construct: function() {
		  this.registered = {}
	    },
	    contains: function(b) {
		  return a.is.defined(this.registered[b])
	    },
	    names: function() {
		  var a, b = [];
		  for (a in this.registered) this.registered.hasOwnProperty(a) && b.push(a);
		  return b
	    },
	    register: function(b, c, d) {
		  if (a.is.string(b) && a.is.fn(c)) {
			var e = this.registered[b];
			this.registered[b] = {
			    name: b,
			    klass: c,
			    priority: a.is.number(d) ? d : a.is.defined(e) ? e.priority : 0
			}
		  }
	    },
	    load: function(b, c, d) {
		  var e, f, g = this,
			h = Array.prototype.slice.call(arguments),
			i = [],
			j = [];
		  b = h.shift() || {};
		  for (e in g.registered)
			if (g.registered.hasOwnProperty(e)) {
			    var k = g.registered[e];
			    b.hasOwnProperty(e) && (f = b[e], a.is.string(f) && (f = a.getFnPointer(b[e])), a.is.fn(f) && (k = {
				  name: e,
				  klass: f,
				  priority: g.registered[e].priority
			    })), i.push(k)
			}
		  for (e in b) b.hasOwnProperty(e) && !g.registered.hasOwnProperty(e) && (f = b[e], a.is.string(f) && (f = a.getFnPointer(b[e])), a.is.fn(f) && i.push({
			name: e,
			klass: f,
			priority: 0
		  }));
		  return i.sort(function(a, b) {
			return b.priority - a.priority
		  }), a.arr.each(i, function(b) {
			a.is.fn(b.klass) && j.push(g._make(b.klass, h))
		  }), j
	    },
	    make: function(b, c, d) {
		  var e, f = this,
			g = Array.prototype.slice.call(arguments);
		  return b = g.shift(), e = f.registered[b], a.is.fn(e.klass) ? f._make(e.klass, g) : null
	    },
	    _make: function(a, b) {
		  function c() {
			return a.apply(this, b)
		  }
		  return c.prototype = a.prototype, new c
	    }
	})
  }(FooTable),
  function(a, b) {
	b.css2json = function(c) {
	    if (b.is.emptyString(c)) return {};
	    for (var d, e, f, g = {}, h = c.split(";"), i = 0, j = h.length; j > i; i++) b.is.emptyString(h[i]) || (d = h[i].split(":"), b.is.emptyString(d[0]) || b.is.emptyString(d[1]) || (e = b.str.toCamelCase(a.trim(d[0])), f = a.trim(d[1]), g[e] = f));
	    return g
	}, b.getFnPointer = function(a) {
	    if (b.is.emptyString(a)) return null;
	    var c = window,
		  d = a.split(".");
	    return b.arr.each(d, function(a) {
		  c[a] && (c = c[a])
	    }), b.is.fn(c) ? c : null
	}, b.checkFnValue = function(a, c, d) {
	    function e(a, c, d) {
		  return b.is.fn(c) ? function() {
			return c.apply(a, arguments)
		  } : d
	    }
	    return d = b.is.fn(d) ? d : null, b.is.fn(c) ? e(a, c, d) : b.is.type(c, "string") ? e(a, b.getFnPointer(c), d) : d
	}
  }(jQuery, FooTable),
  function(a, b) {
	b.Cell = b.Class.extend({
	    construct: function(a, b, c, d) {
		  this.ft = a, this.row = b, this.column = c, this.created = !1, this.define(d)
	    },
	    define: function(c) {
		  this.$el = b.is.element(c) || b.is.jq(c) ? a(c) : null, this.$detail = null;
		  var d = b.is.hash(c) && b.is.hash(c.options) && b.is.defined(c.value);
		  this.value = this.column.parser.call(this.column, b.is.jq(this.$el) ? this.$el : d ? c.value : c, this.ft.o), this.o = a.extend(!0, {
			classes: null,
			style: null
		  }, d ? c.options : {}), this.classes = b.is.jq(this.$el) && this.$el.attr("class") ? this.$el.attr("class").match(/\S+/g) : b.is.array(this.o.classes) ? this.o.classes : b.is.string(this.o.classes) ? this.o.classes.match(/\S+/g) : [], this.style = b.is.jq(this.$el) && this.$el.attr("style") ? b.css2json(this.$el.attr("style")) : b.is.hash(this.o.style) ? this.o.style : b.is.string(this.o.style) ? b.css2json(this.o.style) : {}
	    },
	    $create: function() {
		  this.created || ((this.$el = b.is.jq(this.$el) ? this.$el : a("<td/>")).data("value", this.value).contents().detach().end().append(this.format(this.value)), this._setClasses(this.$el), this._setStyle(this.$el), this.$detail = a("<tr/>").addClass(this.row.classes.join(" ")).data("__FooTableCell__", this).append(a("<th/>")).append(a("<td/>")), this.created = !0)
	    },
	    collapse: function() {
		  this.created && (this.$detail.children("th").html(this.column.title), this.$el.clone().attr("id", this.$el.attr("id") ? this.$el.attr("id") + "-detail" : void 0).css("display", "table-cell").html("").append(this.$el.contents().detach()).replaceAll(this.$detail.children("td").first()), b.is.jq(this.$detail.parent()) || this.$detail.appendTo(this.row.$details.find(".footable-details > tbody")))
	    },
	    restore: function() {
		  if (this.created) {
			if (b.is.jq(this.$detail.parent())) {
			    var a = this.$detail.children("td").first();
			    this.$el.attr("class", a.attr("class")).attr("style", a.attr("style")).css("display", this.column.hidden || !this.column.visible ? "none" : "table-cell").append(a.contents().detach())
			}
			this.$detail.detach()
		  }
	    },
	    parse: function() {
		  return this.column.parser.call(this.column, this.$el, this.ft.o)
	    },
	    format: function(a) {
		  return this.column.formatter.call(this.column, a, this.ft.o)
	    },
	    val: function(c, d) {
		  if (b.is.undef(c)) return this.value;
		  var e = this,
			f = b.is.hash(c) && b.is.hash(c.options) && b.is.defined(c.value);
		  if (this.o = a.extend(!0, {
			    classes: e.classes,
			    style: e.style
			}, f ? c.options : {}), this.value = f ? c.value : c, this.classes = b.is.array(this.o.classes) ? this.o.classes : b.is.string(this.o.classes) ? this.o.classes.match(/\S+/g) : [], this.style = b.is.hash(this.o.style) ? this.o.style : b.is.string(this.o.style) ? b.css2json(this.o.style) : {}, this.created) {
			this.$el.data("value", this.value).empty();
			var g = this.$detail.children("td").first().empty(),
			    h = b.is.jq(this.$detail.parent()) ? g : this.$el;
			h.append(this.format(this.value)), this._setClasses(h), this._setStyle(h), (b.is["boolean"](d) ? d : !0) && this.row.draw()
		  }
	    },
	    _setClasses: function(a) {
		  var c = !b.is.emptyArray(this.column.classes),
			d = !b.is.emptyArray(this.classes),
			e = null;
		  a.removeAttr("class"), (c || d) && (c && d ? e = this.classes.concat(this.column.classes).join(" ") : c ? e = this.column.classes.join(" ") : d && (e = this.classes.join(" ")), b.is.emptyString(e) || a.addClass(e))
	    },
	    _setStyle: function(c) {
		  var d = !b.is.emptyObject(this.column.style),
			e = !b.is.emptyObject(this.style),
			f = null;
		  c.removeAttr("style"), (d || e) && (d && e ? f = a.extend({}, this.column.style, this.style) : d ? f = this.column.style : e && (f = this.style), b.is.hash(f) && c.css(f))
	    }
	})
  }(jQuery, FooTable),
  function(a, b) {
	b.Column = b.Class.extend({
	    construct: function(a, c, d) {
		  this.ft = a, this.type = b.is.emptyString(d) ? "text" : d, this.virtual = b.is["boolean"](c.virtual) ? c.virtual : !1, this.$el = b.is.jq(c.$el) ? c.$el : null, this.index = b.is.number(c.index) ? c.index : -1, this.define(c), this.$create()
	    },
	    define: function(a) {
		  this.hidden = b.is["boolean"](a.hidden) ? a.hidden : !1, this.visible = b.is["boolean"](a.visible) ? a.visible : !0, this.name = b.is.string(a.name) ? a.name : null, null == this.name && (this.name = "col" + (a.index + 1)), this.title = b.is.string(a.title) ? a.title : null, !this.virtual && null == this.title && b.is.jq(this.$el) && (this.title = this.$el.html()), null == this.title && (this.title = "Column " + (a.index + 1)), this.style = b.is.hash(a.style) ? a.style : b.is.string(a.style) ? b.css2json(a.style) : {}, this.classes = b.is.array(a.classes) ? a.classes : b.is.string(a.classes) ? a.classes.match(/\S+/g) : [], this.parser = b.checkFnValue(this, a.parser, this.parser), this.formatter = b.checkFnValue(this, a.formatter, this.formatter)
	    },
	    $create: function() {
		  (this.$el = !this.virtual && b.is.jq(this.$el) ? this.$el : a("<th/>")).html(this.title).addClass(this.classes.join(" ")).css(this.style)
	    },
	    parser: function(c) {
		  if (b.is.element(c) || b.is.jq(c)) {
			var d = a(c).data("value");
			return b.is.defined(d) ? d : a(c).html()
		  }
		  return b.is.defined(c) && null != c ? c + "" : null
	    },
	    formatter: function(a) {
		  return null == a ? "" : a
	    },
	    createCell: function(a) {
		  var c = b.is.jq(a.$el) ? a.$el.children("td,th").get(this.index) : null,
			d = b.is.hash(a.value) ? a.value[this.name] : null;
		  return new b.Cell(this.ft, a, this, c || d)
	    }
	}), b.columns = new b.ClassFactory, b.columns.register("text", b.Column)
  }(jQuery, FooTable),
  function(a, b) {
	b.Component = b.Class.extend({
	    construct: function(a, c) {
		  if (!(a instanceof b.Table)) throw new TypeError("The instance parameter must be an instance of FooTable.Table.");
		  this.ft = a, this.enabled = b.is["boolean"](c) ? c : !1
	    },
	    preinit: function(a) {},
	    init: function() {},
	    destroy: function() {},
	    predraw: function() {},
	    draw: function() {},
	    postdraw: function() {}
	}), b.components = new b.ClassFactory
  }(jQuery, FooTable),
  function(a, b) {
	b.Defaults = function() {
	    this.stopPropagation = !1, this.on = null
	}, b.defaults = new b.Defaults
  }(jQuery, FooTable),
  function(a, b) {
	b.Row = b.Class.extend({
	    construct: function(a, b, c) {
		  this.ft = a, this.columns = b, this.created = !1, this.define(c)
	    },
	    define: function(c) {
		  this.$el = b.is.element(c) || b.is.jq(c) ? a(c) : null, this.$toggle = a("<span/>", {
			"class": "footable-toggle fooicon fooicon-plus"
		  });
		  var d = b.is.hash(c),
			e = d && b.is.hash(c.options) && b.is.hash(c.value);
		  this.value = d ? e ? c.value : c : null, this.o = a.extend(!0, {
			expanded: !1,
			classes: null,
			style: null
		  }, e ? c.options : {}), this.expanded = b.is.jq(this.$el) ? this.$el.data("expanded") || this.o.expanded : this.o.expanded, this.classes = b.is.jq(this.$el) && this.$el.attr("class") ? this.$el.attr("class").match(/\S+/g) : b.is.array(this.o.classes) ? this.o.classes : b.is.string(this.o.classes) ? this.o.classes.match(/\S+/g) : [], this.style = b.is.jq(this.$el) && this.$el.attr("style") ? b.css2json(this.$el.attr("style")) : b.is.hash(this.o.style) ? this.o.style : b.is.string(this.o.style) ? b.css2json(this.o.style) : {}, this.cells = this.createCells();
		  var f = this;
		  f.value = {}, b.arr.each(f.cells, function(a) {
			f.value[a.column.name] = a.val()
		  })
	    },
	    $create: function() {
		  if (!this.created) {
			(this.$el = b.is.jq(this.$el) ? this.$el : a("<tr/>")).data("__FooTableRow__", this), this._setClasses(this.$el), this._setStyle(this.$el), "last" == this.ft.rows.toggleColumn && this.$toggle.addClass("last-column"), this.$details = a("<tr/>", {
			    "class": "footable-detail-row"
			}).append(a("<td/>", {
			    colspan: this.ft.columns.visibleColspan
			}).append(a("<table/>", {
			    "class": "footable-details " + this.ft.classes.join(" ")
			}).append("<tbody/>")));
			var c = this;
			b.arr.each(c.cells, function(a) {
			    a.created || a.$create(), c.$el.append(a.$el)
			}), c.$el.off("click.ft.row").on("click.ft.row", {
			    self: c
			}, c._onToggle), this.created = !0
		  }
	    },
	    createCells: function() {
		  var a = this;
		  return b.arr.map(a.columns, function(b) {
			return b.createCell(a)
		  })
	    },
	    val: function(c, d) {
		  var e = this;
		  if (!b.is.hash(c)) return b.is.hash(this.value) && !b.is.emptyObject(this.value) || (this.value = {}, b.arr.each(this.cells, function(a) {
			e.value[a.column.name] = a.val()
		  })), this.value;
		  this.collapse(!1);
		  var f = b.is.hash(c),
			g = f && b.is.hash(c.options) && b.is.hash(c.value);
		  if (this.o = a.extend(!0, {
			    expanded: e.expanded,
			    classes: e.classes,
			    style: e.style
			}, g ? c.options : {}), this.expanded = this.o.expanded, this.classes = b.is.array(this.o.classes) ? this.o.classes : b.is.string(this.o.classes) ? this.o.classes.match(/\S+/g) : [], this.style = b.is.hash(this.o.style) ? this.o.style : b.is.string(this.o.style) ? b.css2json(this.o.style) : {}, f)
			if (g && (c = c.value), b.is.hash(this.value))
			    for (var h in c) c.hasOwnProperty(h) && (this.value[h] = c[h]);
			else this.value = c;
		  else this.value = null;
		  b.arr.each(this.cells, function(a) {
			b.is.defined(e.value[a.column.name]) && a.val(e.value[a.column.name], !1)
		  }), this.created && (this._setClasses(this.$el), this._setStyle(this.$el), (b.is["boolean"](d) ? d : !0) && this.draw())
	    },
	    _setClasses: function(a) {
		  var c = !b.is.emptyArray(this.classes),
			d = null;
		  a.removeAttr("class"), c && (d = this.classes.join(" "), b.is.emptyString(d) || a.addClass(d))
	    },
	    _setStyle: function(a) {
		  var c = !b.is.emptyObject(this.style),
			d = null;
		  a.removeAttr("style"), c && (d = this.style, b.is.hash(d) && a.css(d))
	    },
	    expand: function() {
		  if (this.created) {
			var a = this;
			a.ft.raise("expand.ft.row", [a]).then(function() {
			    a.__hidden__ = b.arr.map(a.cells, function(a) {
				  return a.column.hidden && a.column.visible ? a : null
			    }), a.__hidden__.length > 0 && (a.$details.insertAfter(a.$el).children("td").first().attr("colspan", a.ft.columns.visibleColspan), b.arr.each(a.__hidden__, function(a) {
				  a.collapse()
			    })), a.$el.attr("data-expanded", !0), a.$toggle.removeClass("fooicon-plus").addClass("fooicon-minus"), a.expanded = !0
			})
		  }
	    },
	    collapse: function(a) {
		  if (this.created) {
			var c = this;
			c.ft.raise("collapse.ft.row", [c]).then(function() {
			    b.arr.each(c.__hidden__, function(a) {
				  a.restore()
			    }), c.$details.detach(), c.$el.removeAttr("data-expanded"), c.$toggle.removeClass("fooicon-minus").addClass("fooicon-plus"), (b.is["boolean"](a) ? a : !0) && (c.expanded = !1)
			})
		  }
	    },
	    predraw: function(a) {
		  this.created && (this.expanded && this.collapse(!1), this.$toggle.detach(), a = b.is["boolean"](a) ? a : !0, a && this.$el.detach())
	    },
	    draw: function(a) {
		  this.created || this.$create(), b.is.jq(a) && a.append(this.$el);
		  var c = this;
		  b.arr.each(c.cells, function(a) {
			a.$el.css("display", a.column.hidden || !a.column.visible ? "none" : "table-cell"), c.ft.rows.showToggle && c.ft.columns.hasHidden && ("first" == c.ft.rows.toggleColumn && a.column.index == c.ft.columns.firstVisibleIndex || "last" == c.ft.rows.toggleColumn && a.column.index == c.ft.columns.lastVisibleIndex) && a.$el.prepend(c.$toggle), a.$el.add(a.column.$el).removeClass("footable-first-visible footable-last-visible"), a.column.index == c.ft.columns.firstVisibleIndex && a.$el.add(a.column.$el).addClass("footable-first-visible"), a.column.index == c.ft.columns.lastVisibleIndex && a.$el.add(a.column.$el).addClass("footable-last-visible")
		  }), this.expanded && this.expand()
	    },
	    toggle: function() {
		  this.created && this.ft.columns.hasHidden && (this.expanded ? this.collapse() : this.expand())
	    },
	    _onToggle: function(b) {
		  var c = b.data.self;
		  a(b.target).is(c.ft.rows.toggleSelector) && c.toggle()
	    }
	})
  }(jQuery, FooTable),
  function(a, b) {
	b.instances = [], b.Table = b.Class.extend({
	    construct: function(c, d, e) {
		  this._resizeTimeout = null, this.id = b.instances.push(this), this.initialized = !1, this.$el = (b.is.jq(c) ? c : a(c)).first(), this.$loader = a("<div/>", {
			"class": "footable-loader"
		  }).append(a("<span/>", {
			"class": "fooicon fooicon-loader"
		  })), this.o = a.extend(!0, {}, b.defaults, d), this.data = this.$el.data() || {}, this.classes = [], this.components = b.components.load(b.is.hash(this.data.components) ? this.data.components : this.o.components, this), this.breakpoints = this.use(FooTable.Breakpoints), this.columns = this.use(FooTable.Columns), this.rows = this.use(FooTable.Rows), this._construct(e)
	    },
	    _construct: function(a) {
		  var c = this;
		  this._preinit().then(function() {
			return c._init()
		  }).always(function(d) {
			return c.$el.show(), b.is.error(d) ? void console.error("FooTable: unhandled error thrown during initialization.", d) : c.raise("ready.ft.table").then(function() {
			    b.is.fn(a) && a.call(c, c)
			})
		  })
	    },
	    _preinit: function() {
		  var a = this;
		  return this.raise("preinit.ft.table", [a.data]).then(function() {
			var c = (a.$el.attr("class") || "").match(/\S+/g) || [];
			a.o.ajax = b.checkFnValue(a, a.data.ajax, a.o.ajax), a.o.stopPropagation = b.is["boolean"](a.data.stopPropagation) ? a.data.stopPropagation : a.o.stopPropagation;
			for (var d = 0, e = c.length; e > d; d++) b.str.startsWith(c[d], "footable") || a.classes.push(c[d]);
			return a.$el.hide().after(a.$loader), a.execute(!1, !1, "preinit", a.data)
		  })
	    },
	    _init: function() {
		  var c = this;
		  return c.raise("init.ft.table").then(function() {
			var d = c.$el.children("thead"),
			    e = c.$el.children("tbody"),
			    f = c.$el.children("tfoot");
			return c.$el.addClass("footable footable-" + c.id), b.is.hash(c.o.on) && c.$el.on(c.o.on), 0 == f.length && c.$el.append(f = a("<tfoot/>")), 0 == e.length && c.$el.append("<tbody/>"), 0 == d.length && c.$el.prepend(d = a("<thead/>")), c.execute(!1, !0, "init").then(function() {
			    return c.$el.data("__FooTable__", c), 0 == f.children("tr").length && f.remove(), 0 == d.children("tr").length && d.remove(), c.raise("postinit.ft.table").then(function() {
				  return c.draw()
			    }).always(function() {
				  a(window).off("resize.ft" + c.id, c._onWindowResize).on("resize.ft" + c.id, {
					self: c
				  }, c._onWindowResize), c.initialized = !0
			    })
			})
		  })
	    },
	    destroy: function() {
		  var c = this;
		  return c.raise("destroy.ft.table").then(function() {
			return c.execute(!0, !0, "destroy").then(function() {
			    c.$el.removeData("__FooTable__").removeClass("footable-" + c.id), b.is.hash(c.o.on) && c.$el.off(c.o.on), a(window).off("resize.ft" + c.id, c._onWindowResize), c.initialized = !1
			})
		  }).fail(function(a) {
			b.is.error(a) && console.error("FooTable: unhandled error thrown while destroying the plugin.", a)
		  })
	    },
	    raise: function(c, d) {
		  var e = this,
			f = b.__debug__ && (b.is.emptyArray(b.__debug_options__.events) || b.arr.any(b.__debug_options__.events, function(a) {
			    return b.str.contains(c, a)
			}));
		  return d = d || [], d.unshift(this), a.Deferred(function(b) {
			var g = a.Event(c);
			1 == e.o.stopPropagation && e.$el.one(c, function(a) {
			    a.stopPropagation()
			}), f && console.log("FooTable:" + c + ": ", d), e.$el.trigger(g, d), g.isDefaultPrevented() ? (f && console.log('FooTable: default prevented for the "' + c + '" event.'), b.reject(g)) : b.resolve(g)
		  })
	    },
	    use: function(a) {
		  for (var b = 0, c = this.components.length; c > b; b++)
			if (this.components[b] instanceof a) return this.components[b];
		  return null
	    },
	    draw: function() {
		  var a = this,
			c = a.$el.clone().insertBefore(a.$el);
		  return a.$el.detach(), a.execute(!1, !0, "predraw").then(function() {
			return a.raise("predraw.ft.table").then(function() {
			    return a.execute(!1, !0, "draw").then(function() {
				  return a.raise("draw.ft.table").then(function() {
					return a.execute(!1, !0, "postdraw").then(function() {
					    return a.raise("postdraw.ft.table")
					})
				  })
			    })
			})
		  }).fail(function(a) {
			b.is.error(a) && console.error("FooTable: unhandled error thrown during a draw operation.", a)
		  }).always(function() {
			c.replaceWith(a.$el), a.$loader.remove()
		  })
	    },
	    execute: function(a, c, d, e, f) {
		  var g = this,
			h = Array.prototype.slice.call(arguments);
		  a = h.shift(), c = h.shift();
		  var i = c ? b.arr.get(g.components, function(a) {
			return a.enabled
		  }) : g.components.slice(0);
		  return h.unshift(a ? i.reverse() : i), g._execute.apply(g, h)
	    },
	    _execute: function(c, d, e, f) {
		  if (!c || !c.length) return a.when();
		  var g, h = this,
			i = Array.prototype.slice.call(arguments);
		  return c = i.shift(), d = i.shift(), g = c.shift(), b.is.fn(g[d]) ? a.Deferred(function(a) {
			try {
			    var c = g[d].apply(g, i);
			    if (b.is.promise(c)) return c.then(a.resolve, a.reject);
			    a.resolve(c)
			} catch (e) {
			    a.reject(e)
			}
		  }).then(function() {
			return h._execute.apply(h, [c, d].concat(i))
		  }) : h._execute.apply(h, [c, d].concat(i))
	    },
	    _onWindowResize: function(a) {
		  var b = a.data.self;
		  null != b._resizeTimeout && clearTimeout(b._resizeTimeout), b._resizeTimeout = setTimeout(function() {
			b._resizeTimeout = null, b.raise("resize.ft.table").then(function() {
			    b.breakpoints.check()
			})
		  }, 300)
	    }
	})
  }(jQuery, FooTable),
  function(a, b) {
	b.is.undef(window.moment) || (b.DateColumn = b.Column.extend({
	    construct: function(a, c) {
		  this._super(a, c, "date"), this.formatString = b.is.string(c.formatString) ? c.formatString : "MM-DD-YYYY"
	    },
	    parser: function(c) {
		  if (b.is.element(c) || b.is.jq(c)) {
			var d = a(c).data("value");
			c = b.is.defined(d) ? d : a(c).text(), b.is.string(c) && (c = isNaN(c) ? c : +c)
		  }
		  if (b.is.date(c)) return moment(c);
		  if (b.is.object(c) && b.is["boolean"](c._isAMomentObject)) return c;
		  if (b.is.string(c)) {
			if (isNaN(c)) return moment(c, this.formatString);
			c = +c
		  }
		  return b.is.number(c) ? moment(c) : null
	    },
	    formatter: function(a) {
		  return b.is.object(a) && b.is["boolean"](a._isAMomentObject) && a.isValid() ? a.format(this.formatString) : ""
	    },
	    filterValue: function(c) {
		  if ((b.is.element(c) || b.is.jq(c)) && (c = a(c).data("filterValue") || a(c).text()), b.is.hash(c) && b.is.hash(c.options) && (b.is.string(c.options.filterValue) && (c = c.options.filterValue), b.is.defined(c.value) && (c = c.value)), b.is.object(c) && b.is["boolean"](c._isAMomentObject)) return c.format(this.formatString);
		  if (b.is.string(c)) {
			if (isNaN(c)) return c;
			c = +c
		  }
		  return b.is.number(c) || b.is.date(c) ? moment(c).format(this.formatString) : b.is.defined(c) && null != c ? c + "" : ""
	    }
	}), b.columns.register("date", b.DateColumn))
  }(jQuery, FooTable),
  function(a, b) {
	b.HTMLColumn = b.Column.extend({
	    construct: function(a, b) {
		  this._super(a, b, "html")
	    },
	    parser: function(c) {
		  if (b.is.string(c) && (c = a(a.trim(c))), b.is.element(c) && (c = a(c)), b.is.jq(c)) {
			var d = c.prop("tagName").toLowerCase();
			if ("td" == d || "th" == d) {
			    var e = c.data("value");
			    return b.is.defined(e) ? e : c.contents()
			}
			return c
		  }
		  return null
	    }
	}), b.columns.register("html", b.HTMLColumn)
  }(jQuery, FooTable),
  function(a, b) {
	b.NumberColumn = b.Column.extend({
	    construct: function(a, c) {
		  this._super(a, c, "number"), this.decimalSeparator = b.is.string(c.decimalSeparator) ? c.decimalSeparator : ".", this.thousandSeparator = b.is.string(c.thousandSeparator) ? c.thousandSeparator : ",", this.decimalSeparatorRegex = new RegExp(b.str.escapeRegExp(this.decimalSeparator), "g"), this.thousandSeparatorRegex = new RegExp(b.str.escapeRegExp(this.thousandSeparator), "g"), this.cleanRegex = new RegExp("[^0-9" + b.str.escapeRegExp(this.decimalSeparator) + "]", "g")
	    },
	    parser: function(c) {
		  if (b.is.element(c) || b.is.jq(c)) {
			var d = a(c).data("value");
			c = b.is.defined(d) ? d : a(c).text().replace(this.cleanRegex, "")
		  }
		  return b.is.string(c) && (c = c.replace(this.thousandSeparatorRegex, "").replace(this.decimalSeparatorRegex, "."), c = parseFloat(c)), b.is.number(c) ? c : null
	    },
	    formatter: function(a) {
		  if (null == a) return "";
		  var b = (a + "").split(".");
		  return 2 == b.length && b[0].length > 3 && (b[0] = b[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, this.thousandSeparator)), b.join(this.decimalSeparator)
	    }
	}), b.columns.register("number", b.NumberColumn)
  }(jQuery, FooTable),
  function(a, b) {
	b.Breakpoint = b.Class.extend({
	    construct: function(a, b) {
		  this.name = a, this.width = b
	    }
	})
  }(jQuery, FooTable),
  function(a, b) {
	b.Breakpoints = b.Component.extend({
	    construct: function(a) {
		  this._super(a, !0), this.o = a.o, this.current = null, this.array = [], this.cascade = this.o.cascade, this.useParentWidth = this.o.useParentWidth, this.hidden = null, this._classNames = "", this.getWidth = b.checkFnValue(this, this.o.getWidth, this.getWidth)
	    },
	    preinit: function(a) {
		  var c = this;
		  return this.ft.raise("preinit.ft.breakpoints", [a]).then(function() {
			c.cascade = b.is["boolean"](a.cascade) ? a.cascade : c.cascade, c.o.breakpoints = b.is.hash(a.breakpoints) ? a.breakpoints : c.o.breakpoints, c.getWidth = b.checkFnValue(c, a.getWidth, c.getWidth), null == c.o.breakpoints && (c.o.breakpoints = {
			    xs: 480,
			    sm: 768,
			    md: 992,
			    lg: 1200
			});
			for (var d in c.o.breakpoints) c.o.breakpoints.hasOwnProperty(d) && (c.array.push(new b.Breakpoint(d, c.o.breakpoints[d])), c._classNames += "breakpoint-" + d + " ");
			c.array.sort(function(a, b) {
			    return b.width - a.width
			})
		  })
	    },
	    init: function() {
		  var a = this;
		  return this.ft.raise("init.ft.breakpoints").then(function() {
			a.current = a.get()
		  })
	    },
	    draw: function() {
		  this.ft.$el.removeClass(this._classNames).addClass("breakpoint-" + this.current.name)
	    },
	    calculate: function() {
		  for (var a, c = this, d = null, e = [], f = null, g = c.getWidth(), h = 0, i = c.array.length; i > h; h++) a = c.array[h], (!d && h == i - 1 || g >= a.width && (f instanceof b.Breakpoint ? g < f.width : !0)) && (d = a), d || e.push(a.name), f = a;
		  return e.push(d.name), c.hidden = e.join(" "), d
	    },
	    visible: function(a) {
		  if (b.is.emptyString(a)) return !0;
		  if ("all" === a) return !1;
		  for (var c = a.split(" "), d = 0, e = c.length; e > d; d++)
			if (this.cascade ? b.str.containsWord(this.hidden, c[d]) : c[d] == this.current.name) return !1;
		  return !0
	    },
	    check: function() {
		  var a = this,
			c = a.get();
		  c instanceof b.Breakpoint && c != a.current && a.ft.raise("before.ft.breakpoints", [a.current, c]).then(function() {
			var b = a.current;
			return a.current = c, a.ft.draw().then(function() {
			    a.ft.raise("after.ft.breakpoints", [a.current, b])
			})
		  })
	    },
	    get: function(a) {
		  return b.is.undef(a) ? this.calculate() : a instanceof b.Breakpoint ? a : b.is.string(a) ? b.arr.first(this.array, function(b) {
			return b.name == a
		  }) : b.is.number(a) && a >= 0 && a < this.array.length ? this.array[a] : null
	    },
	    getWidth: function() {
		  return b.is.fn(this.o.getWidth) ? this.o.getWidth(this.ft) : 1 == this.useParentWidth ? this.getParentWidth() : this.getViewportWidth()
	    },
	    getParentWidth: function() {
		  return this.ft.$el.parent().width()
	    },
	    getViewportWidth: function() {
		  return Math.max(document.documentElement.clientWidth, window.innerWidth, 0)
	    }
	}), b.components.register("breakpoints", b.Breakpoints, 1e3)
  }(jQuery, FooTable),
  function(a) {
	a.Column.prototype.breakpoints = null, a.Column.prototype.__breakpoints_define__ = function(b) {
	    this.breakpoints = a.is.emptyString(b.breakpoints) ? null : b.breakpoints
	}, a.Column.extend("define", function(a) {
	    this._super(a), this.__breakpoints_define__(a)
	})
  }(FooTable),
  function(a) {
	a.Defaults.prototype.breakpoints = null, a.Defaults.prototype.cascade = !1, a.Defaults.prototype.useParentWidth = !1, a.Defaults.prototype.getWidth = null
  }(FooTable),
  function(a, b) {
	b.Columns = b.Component.extend({
	    construct: function(a) {
		  this._super(a, !0), this.o = a.o, this.array = [], this.$header = null, this.showHeader = a.o.showHeader, this._fromHTML = b.is.emptyArray(a.o.columns) && !b.is.promise(a.o.columns)
	    },
	    parse: function(c) {
		  var d = this;
		  return a.Deferred(function(c) {
			function e(c, d) {
			    var e = [];
			    if (0 == c.length || 0 == d.length) e = c.concat(d);
			    else {
				  var f = 0;
				  b.arr.each(c.concat(d), function(a) {
					a.index > f && (f = a.index)
				  }), f++;
				  for (var g, h, i = 0; f > i; i++) g = {}, b.arr.each(c, function(a) {
					return a.index == i ? (g = a, !1) : void 0
				  }), h = {}, b.arr.each(d, function(a) {
					return a.index == i ? (h = a, !1) : void 0
				  }), e.push(a.extend(!0, {}, g, h))
			    }
			    return e
			}
			var f, g, h = [],
			    i = [],
			    j = d.ft.$el.find("tr.footable-header, thead > tr:last:has([data-breakpoints]), tbody > tr:first:has([data-breakpoints]), thead > tr:last, tbody > tr:first").first();
			if (j.length > 0) {
			    var k = j.parent().is("tbody") && j.children().length == j.children("td").length;
			    k || (d.$header = j.addClass("footable-header")), j.children("td,th").each(function(b, c) {
				  f = a(c), g = f.data(), g.index = b, g.$el = f, g.virtual = k, i.push(g)
			    }), k && (d.showHeader = !1)
			}
			b.is.array(d.o.columns) && !b.is.emptyArray(d.o.columns) ? (b.arr.each(d.o.columns, function(a, b) {
			    a.index = b, h.push(a)
			}), d.parseFinalize(c, e(h, i))) : b.is.promise(d.o.columns) ? d.o.columns.then(function(a) {
			    b.arr.each(a, function(a, b) {
				  a.index = b, h.push(a)
			    }), d.parseFinalize(c, e(h, i))
			}, function(a) {
			    c.reject(Error("Columns ajax request error: " + a.status + " (" + a.statusText + ")"))
			}) : d.parseFinalize(c, e(h, i))
		  })
	    },
	    parseFinalize: function(a, c) {
		  var d, e = this,
			f = [];
		  b.arr.each(c, function(a) {
			(d = b.columns.contains(a.type) ? b.columns.make(a.type, e.ft, a) : new b.Column(e.ft, a)) && f.push(d)
		  }), b.is.emptyArray(f) ? a.reject(Error("No columns supplied.")) : (f.sort(function(a, b) {
			return a.index - b.index
		  }), a.resolve(f))
	    },
	    preinit: function(a) {
		  var c = this;
		  return c.ft.raise("preinit.ft.columns", [a]).then(function() {
			return c.parse(a).then(function(d) {
			    c.array = d, c.showHeader = b.is["boolean"](a.showHeader) ? a.showHeader : c.showHeader
			})
		  })
	    },
	    init: function() {
		  var a = this;
		  return this.ft.raise("init.ft.columns", [a.array]).then(function() {
			a.$create()
		  })
	    },
	    destroy: function() {
		  var a = this;
		  this.ft.raise("destroy.ft.columns").then(function() {
			a._fromHTML || a.$header.remove()
		  })
	    },
	    predraw: function() {
		  var a = this,
			c = !0;
		  a.visibleColspan = 0, a.firstVisibleIndex = 0, a.lastVisibleIndex = 0, a.hasHidden = !1, b.arr.each(a.array, function(b) {
			b.hidden = !a.ft.breakpoints.visible(b.breakpoints), !b.hidden && b.visible && (c && (a.firstVisibleIndex = b.index, c = !1), a.lastVisibleIndex = b.index, a.visibleColspan++), b.hidden && (a.hasHidden = !0)
		  }), a.ft.$el.toggleClass("breakpoint", a.hasHidden)
	    },
	    draw: function() {
		  b.arr.each(this.array, function(a) {
			a.$el.css("display", a.hidden || !a.visible ? "none" : "table-cell")
		  }), !this.showHeader && b.is.jq(this.$header.parent()) && this.$header.detach()
	    },
	    $create: function() {
		  var c = this;
		  c.$header = b.is.jq(c.$header) ? c.$header : a("<tr/>", {
			"class": "footable-header"
		  }), c.$header.children("th,td").detach(), b.arr.each(c.array, function(a) {
			c.$header.append(a.$el)
		  }), c.showHeader && !b.is.jq(c.$header.parent()) && c.ft.$el.children("thead").append(c.$header)
	    },
	    get: function(a) {
		  return a instanceof b.Column ? a : b.is.string(a) ? b.arr.first(this.array, function(b) {
			return b.name == a
		  }) : b.is.number(a) ? b.arr.first(this.array, function(b) {
			return b.index == a
		  }) : b.is.fn(a) ? b.arr.get(this.array, a) : null
	    },
	    ensure: function(a) {
		  var c = this,
			d = [];
		  return b.is.array(a) ? (b.arr.each(a, function(a) {
			d.push(c.get(a))
		  }), d) : d
	    }
	}), b.components.register("columns", b.Columns, 900)
  }(jQuery, FooTable),
  function(a) {
	a.Defaults.prototype.columns = [], a.Defaults.prototype.showHeader = !0
  }(FooTable),
  function(a, b) {
	b.Rows = b.Component.extend({
	    construct: function(a) {
		  this._super(a, !0), this.o = a.o, this.array = [], this.all = [], this.showToggle = a.o.showToggle, this.toggleSelector = a.o.toggleSelector, this.toggleColumn = a.o.toggleColumn, this.emptyString = a.o.empty, this.expandFirst = a.o.expandFirst, this.expandAll = a.o.expandAll, this.$empty = null, this._fromHTML = b.is.emptyArray(a.o.rows) && !b.is.promise(a.o.rows)
	    },
	    parse: function() {
		  var c = this;
		  return a.Deferred(function(a) {
			var d = c.ft.$el.children("tbody").children("tr");
			b.is.array(c.o.rows) && c.o.rows.length > 0 ? c.parseFinalize(a, c.o.rows) : b.is.promise(c.o.rows) ? c.o.rows.then(function(b) {
			    c.parseFinalize(a, b)
			}, function(b) {
			    a.reject(Error("Rows ajax request error: " + b.status + " (" + b.statusText + ")"))
			}) : b.is.jq(d) ? (c.parseFinalize(a, d), d.detach()) : c.parseFinalize(a, [])
		  })
	    },
	    parseFinalize: function(c, d) {
		  var e = this,
			f = a.map(d, function(a) {
			    return new b.Row(e.ft, e.ft.columns.array, a)
			});
		  c.resolve(f)
	    },
	    preinit: function(a) {
		  var c = this;
		  return c.ft.raise("preinit.ft.rows", [a]).then(function() {
			return c.parse().then(function(d) {
			    c.all = d, c.array = c.all.slice(0), c.showToggle = b.is["boolean"](a.showToggle) ? a.showToggle : c.showToggle, c.toggleSelector = b.is.string(a.toggleSelector) ? a.toggleSelector : c.toggleSelector, c.toggleColumn = b.is.string(a.toggleColumn) ? a.toggleColumn : c.toggleColumn, "first" != c.toggleColumn && "last" != c.toggleColumn && (c.toggleColumn = "first"), c.emptyString = b.is.string(a.empty) ? a.empty : c.emptyString, c.expandFirst = b.is["boolean"](a.expandFirst) ? a.expandFirst : c.expandFirst, c.expandAll = b.is["boolean"](a.expandAll) ? a.expandAll : c.expandAll
			})
		  })
	    },
	    init: function() {
		  var a = this;
		  return a.ft.raise("init.ft.rows", [a.all]).then(function() {
			a.$create()
		  })
	    },
	    destroy: function() {
		  var a = this;
		  this.ft.raise("destroy.ft.rows").then(function() {
			b.arr.each(a.array, function(b) {
			    b.predraw(!a._fromHTML)
			})
		  })
	    },
	    predraw: function() {
		  b.arr.each(this.array, function(a) {
			a.predraw()
		  }), this.array = this.all.slice(0)
	    },
	    $create: function() {
		  this.$empty = a("<tr/>", {
			"class": "footable-empty"
		  }).append(a("<td/>").text(this.emptyString))
	    },
	    draw: function() {
		  var a = this,
			c = a.ft.$el.children("tbody"),
			d = !0;
		  a.array.length > 0 ? (a.$empty.detach(), b.arr.each(a.array, function(b) {
			(a.expandFirst && d || a.expandAll) && (b.expanded = !0, d = !1), b.draw(c)
		  })) : (a.$empty.children("td").attr("colspan", a.ft.columns.visibleColspan), c.append(a.$empty))
	    },
	    load: function(c, d) {
		  var e = this,
			f = a.map(c, function(a) {
			    return new b.Row(e.ft, e.ft.columns.array, a)
			});
		  b.arr.each(this.array, function(a) {
			a.predraw()
		  }), this.all = (b.is["boolean"](d) ? d : !1) ? this.all.concat(f) : f, this.array = this.all.slice(0), this.ft.draw()
	    },
	    expand: function() {
		  b.arr.each(this.array, function(a) {
			a.expand()
		  })
	    },
	    collapse: function() {
		  b.arr.each(this.array, function(a) {
			a.collapse()
		  })
	    }
	}), b.components.register("rows", b.Rows, 800)
  }(jQuery, FooTable),
  function(a) {
	a.Defaults.prototype.rows = [], a.Defaults.prototype.empty = "No results", a.Defaults.prototype.showToggle = !0, a.Defaults.prototype.toggleSelector = "tr,td,.footable-toggle", a.Defaults.prototype.toggleColumn = "first", a.Defaults.prototype.expandFirst = !1, a.Defaults.prototype.expandAll = !1
  }(FooTable),
  function(a) {
	a.Table.prototype.loadRows = function(a, b) {
	    this.rows.load(a, b)
	}
  }(FooTable),
  function(a) {
	a.Filter = a.Class.extend({
	    construct: function(b, c, d, e, f, g, h) {
		  this.name = b, this.space = !a.is.string(e) || "OR" != e && "AND" != e ? "AND" : e, this.connectors = a.is["boolean"](f) ? f : !0, this.ignoreCase = a.is["boolean"](g) ? g : !0, this.hidden = a.is["boolean"](h) ? h : !1, this.query = c instanceof a.Query ? c : new a.Query(c, this.space, this.connectors, this.ignoreCase), this.columns = d
	    },
	    match: function(b) {
		  return a.is.string(b) ? (a.is.string(this.query) && (this.query = new a.Query(this.query, this.space, this.connectors, this.ignoreCase)), this.query instanceof a.Query ? this.query.match(b) : !1) : !1
	    },
	    matchRow: function(b) {
		  var c = this,
			d = a.arr.map(b.cells, function(b) {
			    return a.arr.contains(c.columns, b.column) ? b.filterValue : null
			}).join(" ");
		  return c.match(d)
	    }
	})
  }(FooTable),
  function(a, b) {
	b.Filtering = b.Component.extend({
	    construct: function(a) {
		  this._super(a, a.o.filtering.enabled), this.filters = a.o.filtering.filters, this.delay = a.o.filtering.delay, this.min = a.o.filtering.min, this.space = a.o.filtering.space, this.connectors = a.o.filtering.connectors, this.ignoreCase = a.o.filtering.ignoreCase, this.exactMatch = a.o.filtering.exactMatch, this.placeholder = a.o.filtering.placeholder, this.dropdownTitle = a.o.filtering.dropdownTitle, this.position = a.o.filtering.position, this.$row = null, this.$cell = null, this.$dropdown = null, this.$input = null, this.$button = null, this._filterTimeout = null, this._exactRegExp = /^"(.*?)"$/
	    },
	    preinit: function(a) {
		  var c = this;
		  return c.ft.raise("preinit.ft.filtering").then(function() {
			c.ft.$el.hasClass("footable-filtering") && (c.enabled = !0), c.enabled = b.is["boolean"](a.filtering) ? a.filtering : c.enabled, c.enabled && (c.space = b.is.string(a.filterSpace) ? a.filterSpace : c.space, c.min = b.is.number(a.filterMin) ? a.filterMin : c.min, c.connectors = b.is["boolean"](a.filterConnectors) ? a.filterConnectors : c.connectors, c.ignoreCase = b.is["boolean"](a.filterIgnoreCase) ? a.filterIgnoreCase : c.ignoreCase, c.exactMatch = b.is["boolean"](a.filterExactMatch) ? a.filterExactMatch : c.exactMatch, c.delay = b.is.number(a.filterDelay) ? a.filterDelay : c.delay, c.placeholder = b.is.string(a.filterPlaceholder) ? a.filterPlaceholder : c.placeholder, c.dropdownTitle = b.is.string(a.filterDropdownTitle) ? a.filterDropdownTitle : c.dropdownTitle, c.filters = b.is.array(a.filterFilters) ? c.ensure(a.filterFilters) : c.ensure(c.filters), c.ft.$el.hasClass("footable-filtering-left") && (c.position = "left"), c.ft.$el.hasClass("footable-filtering-center") && (c.position = "center"), c.ft.$el.hasClass("footable-filtering-right") && (c.position = "right"), c.position = b.is.string(a.filterPosition) ? a.filterPosition : c.position)
		  }, function() {
			c.enabled = !1
		  })
	    },
	    init: function() {
		  var a = this;
		  return a.ft.raise("init.ft.filtering").then(function() {
			a.$create()
		  }, function() {
			a.enabled = !1
		  })
	    },
	    destroy: function() {
		  var a = this;
		  return a.ft.raise("destroy.ft.filtering").then(function() {
			a.ft.$el.removeClass("footable-filtering").find("thead > tr.footable-filtering").remove()
		  })
	    },
	    $create: function() {
		  var c, d = this,
			e = a("<div/>", {
			    "class": "form-group footable-filtering-search"
			}).append(a("<label/>", {
			    "class": "sr-only",
			    text: "Search"
			})),
			f = a("<div/>", {
			    "class": "input-group"
			}).appendTo(e),
			g = a("<div/>", {
			    "class": "input-group-btn"
			}),
			h = a("<button/>", {
			    type: "button",
			    "class": "btn btn-default dropdown-toggle"
			}).on("click", {
			    self: d
			}, d._onDropdownToggleClicked).append(a("<span/>", {
			    "class": "caret"
			}));
		  switch (d.position) {
			case "left":
			    c = "footable-filtering-left";
			    break;
			case "center":
			    c = "footable-filtering-center";
			    break;
			default:
			    c = "footable-filtering-right"
		  }
		  d.ft.$el.addClass("footable-filtering").addClass(c), d.$row = a("<tr/>", {
			"class": "footable-filtering"
		  }).prependTo(d.ft.$el.children("thead")), d.$cell = a("<th/>").attr("colspan", d.ft.columns.visibleColspan).appendTo(d.$row), d.$form = a("<form/>", {
			"class": "form-inline"
		  }).append(e).appendTo(d.$cell), d.$input = a("<input/>", {
			type: "text",
			"class": "form-control",
			placeholder: d.placeholder
		  }), d.$button = a("<button/>", {
			type: "button",
			"class": "btn btn-primary"
		  }).on("click", {
			self: d
		  }, d._onSearchButtonClicked).append(a("<span/>", {
			"class": "fooicon fooicon-search"
		  })), d.$dropdown = a("<ul/>", {
			"class": "dropdown-menu dropdown-menu-right"
		  }), b.is.emptyString(d.dropdownTitle) || d.$dropdown.append(a("<li/>", {
			"class": "dropdown-header",
			text: d.dropdownTitle
		  })), d.$dropdown.append(b.arr.map(d.ft.columns.array, function(b) {
			return b.filterable ? a("<li/>").append(a("<a/>", {
			    "class": "checkbox"
			}).append(a("<label/>", {
			    text: b.title
			}).prepend(a("<input/>", {
			    type: "checkbox",
			    checked: !0
			}).data("__FooTableColumn__", b)))) : null
		  })), d.delay > 0 && (d.$input.on("keypress keyup paste", {
			self: d
		  }, d._onSearchInputChanged), d.$dropdown.on("click", 'input[type="checkbox"]', {
			self: d
		  }, d._onSearchColumnClicked)), g.append(d.$button, h, d.$dropdown), f.append(d.$input, g)
	    },
	    predraw: function() {
		  if (!b.is.emptyArray(this.filters)) {
			var c = this;
			c.ft.rows.array = a.grep(c.ft.rows.array, function(a) {
			    return a.filtered(c.filters)
			})
		  }
	    },
	    draw: function() {
		  this.$cell.attr("colspan", this.ft.columns.visibleColspan);
		  var a = this.find("search");
		  if (a instanceof b.Filter) {
			var c = a.query.val();
			this.exactMatch && this._exactRegExp.test(c) && (c = c.replace(this._exactRegExp, "$1")), this.$input.val(c)
		  } else this.$input.val(null);
		  this.setButton(!b.arr.any(this.filters, function(a) {
			return !a.hidden
		  }))
	    },
	    addFilter: function(a, c, d, e, f, g, h) {
		  var i = this.createFilter(a, c, d, e, f, g, h);
		  i instanceof b.Filter && (this.removeFilter(i.name), this.filters.push(i))
	    },
	    removeFilter: function(a) {
		  b.arr.remove(this.filters, function(b) {
			return b.name == a
		  })
	    },
	    filter: function() {
		  var a = this;
		  return a.filters = a.ensure(a.filters), a.ft.raise("before.ft.filtering", [a.filters]).then(function() {
			return a.filters = a.ensure(a.filters), a.ft.draw().then(function() {
			    a.ft.raise("after.ft.filtering", [a.filters])
			})
		  })
	    },
	    clear: function() {
		  return this.filters = b.arr.get(this.filters, function(a) {
			return a.hidden
		  }), this.filter()
	    },
	    setButton: function(a) {
		  a ? this.$button.children(".fooicon").removeClass("fooicon-remove").addClass("fooicon-search") : this.$button.children(".fooicon").removeClass("fooicon-search").addClass("fooicon-remove")
	    },
	    find: function(a) {
		  return b.arr.first(this.filters, function(b) {
			return b.name == a
		  })
	    },
	    columns: function() {
		  return b.is.jq(this.$dropdown) ? this.$dropdown.find("input:checked").map(function() {
			return a(this).data("__FooTableColumn__")
		  }).get() : this.ft.columns.get(function(a) {
			return a.filterable
		  })
	    },
	    ensure: function(a) {
		  var c = this,
			d = [],
			e = c.columns();
		  return b.is.emptyArray(a) || b.arr.each(a, function(a) {
			a = c._ensure(a, e), a instanceof b.Filter && d.push(a)
		  }), d
	    },
	    createFilter: function(a, c, d, e, f, g, h) {
		  return b.is.string(a) && (a = {
			name: a,
			query: c,
			columns: d,
			ignoreCase: e,
			connectors: f,
			space: g,
			hidden: h
		  }), this._ensure(a, this.columns())
	    },
	    _ensure: function(a, c) {
		  return (b.is.hash(a) || a instanceof b.Filter) && !b.is.emptyString(a.name) && (!b.is.emptyString(a.query) || a.query instanceof b.Query) ? (a.columns = b.is.emptyArray(a.columns) ? c : this.ft.columns.ensure(a.columns), a.ignoreCase = b.is["boolean"](a.ignoreCase) ? a.ignoreCase : this.ignoreCase, a.connectors = b.is["boolean"](a.connectors) ? a.connectors : this.connectors, a.hidden = b.is["boolean"](a.hidden) ? a.hidden : !1, a.space = !b.is.string(a.space) || "AND" !== a.space && "OR" !== a.space ? this.space : a.space, a.query = b.is.string(a.query) ? new b.Query(a.query, a.space, a.connectors, a.ignoreCase) : a.query, a instanceof b.Filter ? a : new b.Filter(a.name, a.query, a.columns, a.space, a.connectors, a.ignoreCase, a.hidden)) : null
	    },
	    _onSearchInputChanged: function(a) {
		  var c = a.data.self,
			d = "keypress" == a.type && !b.is.emptyString(String.fromCharCode(a.charCode)),
			e = "keyup" == a.type && (8 == a.which || 46 == a.which),
			f = "paste" == a.type;
		  (d || e || f) && (13 == a.which && a.preventDefault(), null != c._filterTimeout && clearTimeout(c._filterTimeout), c._filterTimeout = setTimeout(function() {
			c._filterTimeout = null;
			var a = c.$input.val();
			a.length >= c.min ? (c.exactMatch && !c._exactRegExp.test(a) && (a = '"' + a + '"'), c.addFilter("search", a), c.filter()) : b.is.emptyString(a) && c.clear()
		  }, c.delay))
	    },
	    _onSearchButtonClicked: function(a) {
		  a.preventDefault();
		  var b = a.data.self;
		  null != b._filterTimeout && clearTimeout(b._filterTimeout);
		  var c = b.$button.children(".fooicon");
		  if (c.hasClass("fooicon-remove")) b.clear();
		  else {
			var d = b.$input.val();
			d.length >= b.min && (b.exactMatch && !b._exactRegExp.test(d) && (d = '"' + d + '"'), b.addFilter("search", d), b.filter())
		  }
	    },
	    _onSearchColumnClicked: function(a) {
		  var b = a.data.self;
		  null != b._filterTimeout && clearTimeout(b._filterTimeout), b._filterTimeout = setTimeout(function() {
			b._filterTimeout = null;
			var a = b.$button.children(".fooicon");
			a.hasClass("fooicon-remove") && (a.removeClass("fooicon-remove").addClass("fooicon-search"), b.addFilter("search", b.$input.val()), b.filter())
		  }, b.delay)
	    },
	    _onDropdownToggleClicked: function(b) {
		  b.preventDefault(), b.stopPropagation();
		  var c = b.data.self;
		  c.$dropdown.parent().toggleClass("open"), c.$dropdown.parent().hasClass("open") ? a(document).on("click.footable", {
			self: c
		  }, c._onDocumentClicked) : a(document).off("click.footable", c._onDocumentClicked)
	    },
	    _onDocumentClicked: function(b) {
		  if (0 == a(b.target).closest(".dropdown-menu").length) {
			b.preventDefault();
			var c = b.data.self;
			c.$dropdown.parent().removeClass("open"), a(document).off("click.footable", c._onDocumentClicked)
		  }
	    }
	}), b.components.register("filtering", b.Filtering, 500)
  }(jQuery, FooTable),
  function(a) {
	a.Query = a.Class.extend({
	    construct: function(b, c, d, e) {
		  this._original = null, this._value = null, this.space = !a.is.string(c) || "OR" != c && "AND" != c ? "AND" : c, this.connectors = a.is["boolean"](d) ? d : !0, this.ignoreCase = a.is["boolean"](e) ? e : !0, this.left = null, this.right = null, this.parts = [], this.operator = null, this.val(b)
	    },
	    val: function(b) {
		  if (a.is.emptyString(b)) return this._value;
		  if (a.is.emptyString(this._original)) this._original = b;
		  else if (this._original == b) return;
		  this._value = b, this._parse()
	    },
	    match: function(b) {
		  return a.is.emptyString(this.operator) || "OR" === this.operator ? this._left(b, !1) || this._match(b, !1) || this._right(b, !1) : "AND" === this.operator ? this._left(b, !0) && this._match(b, !0) && this._right(b, !0) : void 0
	    },
	    _match: function(b, c) {
		  var d = this,
			e = !1,
			f = a.is.emptyString(b);
		  return a.is.emptyArray(d.parts) && d.left instanceof a.Query ? c : a.is.emptyArray(d.parts) ? e : ("OR" === d.space ? a.arr.each(d.parts, function(c) {
			if (c.empty && f) {
			    if (e = !0, c.negate) return e = !1
			} else {
			    var g = (c.exact ? a.str.containsExact : a.str.contains)(b, c.query, d.ignoreCase);
			    if (g && !c.negate && (e = !0), g && c.negate) return e = !1
			}
		  }) : (e = !0, a.arr.each(d.parts, function(c) {
			if (c.empty) return (!f && !c.negate || f && c.negate) && (e = !1), e;
			var g = (c.exact ? a.str.containsExact : a.str.contains)(b, c.query, d.ignoreCase);
			return (!g && !c.negate || g && c.negate) && (e = !1), e
		  })), e)
	    },
	    _left: function(b, c) {
		  return this.left instanceof a.Query ? this.left.match(b) : c
	    },
	    _right: function(b, c) {
		  return this.right instanceof a.Query ? this.right.match(b) : c
	    },
	    _parse: function() {
		  if (!a.is.emptyString(this._value))
			if (/\sOR\s/.test(this._value)) {
			    this.operator = "OR";
			    var b = this._value.split(/(?:\sOR\s)(.*)?/);
			    this.left = new a.Query(b[0], this.space, this.connectors, this.ignoreCase), this.right = new a.Query(b[1], this.space, this.connectors, this.ignoreCase)
			} else if (/\sAND\s/.test(this._value)) {
			this.operator = "AND";
			var c = this._value.split(/(?:\sAND\s)(.*)?/);
			this.left = new a.Query(c[0], this.space, this.connectors, this.ignoreCase), this.right = new a.Query(c[1], this.space, this.connectors, this.ignoreCase)
		  } else {
			var d = this;
			this.parts = a.arr.map(this._value.match(/(?:[^\s"]+|"[^"]*")+/g), function(a) {
			    return d._part(a)
			})
		  }
	    },
	    _part: function(b) {
		  var c = {
			query: b,
			negate: !1,
			phrase: !1,
			exact: !1,
			empty: !1
		  };
		  return a.str.startsWith(c.query, "-") && (c.query = a.str.from(c.query, "-"), c.negate = !0), /^"(.*?)"$/.test(c.query) ? (c.query = c.query.replace(/^"(.*?)"$/, "$1"), c.phrase = !0, c.exact = !0) : this.connectors && /(?:\w)+?([-_\+\.])(?:\w)+?/.test(c.query) && (c.query = c.query.replace(/(?:\w)+?([-_\+\.])(?:\w)+?/g, function(a, b) {
			return a.replace(b, " ")
		  }), c.phrase = !0), c.empty = c.phrase && a.is.emptyString(c.query), c
	    }
	})
  }(FooTable),
  function(a) {
	a.Cell.prototype.filterValue = null, a.Cell.prototype.__filtering_define__ = function(a) {
	    this.filterValue = this.column.filterValue.call(this.column, a)
	}, a.Cell.prototype.__filtering_val__ = function(b) {
	    a.is.defined(b) && (this.filterValue = this.column.filterValue.call(this.column, b))
	}, a.Cell.extend("define", function(a) {
	    this._super(a), this.__filtering_define__(a)
	}), a.Cell.extend("val", function(a) {
	    var b = this._super(a);
	    return this.__filtering_val__(a), b
	})
  }(FooTable),
  function(a, b) {
	b.Column.prototype.filterable = !0, b.Column.prototype.filterValue = function(c) {
	    if (b.is.element(c) || b.is.jq(c)) {
		  var d = a(c).data("filterValue");
		  return b.is.defined(d) ? "" + d : a(c).text()
	    }
	    if (b.is.hash(c) && b.is.hash(c.options)) {
		  if (b.is.string(c.options.filterValue)) return c.options.filterValue;
		  b.is.defined(c.value) && (c = c.value)
	    }
	    return b.is.defined(c) && null != c ? c + "" : ""
	}, b.Column.prototype.__filtering_define__ = function(a) {
	    this.filterable = b.is["boolean"](a.filterable) ? a.filterable : this.filterable, this.filterValue = b.checkFnValue(this, a.filterValue, this.filterValue)
	}, b.Column.extend("define", function(a) {
	    this._super(a), this.__filtering_define__(a)
	})
  }(jQuery, FooTable),
  function(a) {
	a.Defaults.prototype.filtering = {
	    enabled: !1,
	    filters: [],
	    delay: 1200,
	    min: 1,
	    space: "AND",
	    placeholder: "Search",
	    dropdownTitle: null,
	    position: "right",
	    connectors: !0,
	    ignoreCase: !0,
	    exactMatch: !1
	}
  }(FooTable),
  function(a) {
	a.Row.prototype.filtered = function(b) {
	    var c = !0,
		  d = this;
	    return a.arr.each(b, function(a) {
		  return 0 == (c = a.matchRow(d)) ? !1 : void 0
	    }), c
	}
  }(FooTable),
  function(a, b) {
	b.Sorter = b.Class.extend({
	    construct: function(a, b) {
		  this.column = a, this.direction = b
	    }
	})
  }(jQuery, FooTable),
  function(a, b) {
	b.Sorting = b.Component.extend({
	    construct: function(a) {
		  this._super(a, a.o.sorting.enabled), this.o = a.o.sorting, this.column = null, this.allowed = !0, this.initial = null
	    },
	    preinit: function(a) {
		  var c = this;
		  this.ft.raise("preinit.ft.sorting", [a]).then(function() {
			c.ft.$el.hasClass("footable-sorting") && (c.enabled = !0), c.enabled = b.is["boolean"](a.sorting) ? a.sorting : c.enabled, c.enabled && (c.column = b.arr.first(c.ft.columns.array, function(a) {
			    return a.sorted
			}))
		  }, function() {
			c.enabled = !1
		  })
	    },
	    init: function() {
		  var c = this;
		  this.ft.raise("init.ft.sorting").then(function() {
			if (!c.initial) {
			    var d = !!c.column;
			    c.initial = {
				  isset: d,
				  rows: c.ft.rows.all.slice(0),
				  column: d ? c.column.name : null,
				  direction: d ? c.column.direction : null
			    }
			}
			b.arr.each(c.ft.columns.array, function(b) {
			    b.sortable && b.$el.addClass("footable-sortable").append(a("<span/>", {
				  "class": "fooicon fooicon-sort"
			    }))
			}), c.ft.$el.on("click.footable", ".footable-sortable", {
			    self: c
			}, c._onSortClicked)
		  }, function() {
			c.enabled = !1
		  })
	    },
	    destroy: function() {
		  var a = this;
		  this.ft.raise("destroy.ft.paging").then(function() {
			a.ft.$el.off("click.footable", ".footable-sortable", a._onSortClicked), a.ft.$el.children("thead").children("tr.footable-header").children(".footable-sortable").removeClass("footable-sortable footable-asc footable-desc").find("span.fooicon").remove()
		  })
	    },
	    predraw: function() {
		  if (this.column) {
			var a = this,
			    b = a.column;
			a.ft.rows.array.sort(function(a, c) {
			    return "DESC" == b.direction ? b.sorter(c.cells[b.index].sortValue, a.cells[b.index].sortValue) : b.sorter(a.cells[b.index].sortValue, c.cells[b.index].sortValue)
			})
		  }
	    },
	    draw: function() {
		  if (this.column) {
			var a = this,
			    b = a.ft.$el.find("thead > tr > .footable-sortable"),
			    c = a.column.$el;
			b.removeClass("footable-asc footable-desc").children(".fooicon").removeClass("fooicon-sort fooicon-sort-asc fooicon-sort-desc"), b.not(c).children(".fooicon").addClass("fooicon-sort"), c.addClass("DESC" == a.column.direction ? "footable-desc" : "footable-asc").children(".fooicon").addClass("DESC" == a.column.direction ? "fooicon-sort-desc" : "fooicon-sort-asc")
		  }
	    },
	    sort: function(a, b) {
		  return this._sort(a, b)
	    },
	    toggleAllowed: function(a) {
		  a = b.is["boolean"](a) ? a : !this.allowed, this.allowed = a, this.ft.$el.toggleClass("footable-sorting-disabled", !this.allowed)
	    },
	    hasChanged: function() {
		  return !(!this.initial || !this.column || this.column.name === this.initial.column && (this.column.direction === this.initial.direction || null === this.initial.direction && "ASC" === this.column.direction))
	    },
	    reset: function() {
		  this.initial && (this.initial.isset ? this.sort(this.initial.column, this.initial.direction) : (this.column && (this.column.$el.removeClass("footable-asc footable-desc"), this.column = null), this.ft.rows.all = this.initial.rows, this.ft.draw()))
	    },
	    _sort: function(c, d) {
		  if (!this.allowed) return a.Deferred().reject("sorting disabled");
		  var e = this,
			f = new b.Sorter(e.ft.columns.get(c), b.Sorting.dir(d));
		  return e.ft.raise("before.ft.sorting", [f]).then(function() {
			return b.arr.each(e.ft.columns.array, function(a) {
			    a != e.column && (a.direction = null)
			}), e.column = e.ft.columns.get(f.column), e.column && (e.column.direction = b.Sorting.dir(f.direction)), e.ft.draw().then(function() {
			    e.ft.raise("after.ft.sorting", [f])
			})
		  })
	    },
	    _onSortClicked: function(b) {
		  var c = b.data.self,
			d = a(this).closest("th,td"),
			e = d.is(".footable-asc, .footable-desc") ? d.hasClass("footable-desc") ? "ASC" : "DESC" : "ASC";
		  c._sort(d.index(), e)
	    }
	}), b.Sorting.dir = function(a) {
	    return !b.is.string(a) || "ASC" != a && "DESC" != a ? "ASC" : a
	}, b.components.register("sorting", b.Sorting, 600)
  }(jQuery, FooTable),
  function(a) {
	a.Cell.prototype.sortValue = null, a.Cell.prototype.__sorting_define__ = function(a) {
	    this.sortValue = this.column.sortValue.call(this.column, a)
	}, a.Cell.prototype.__sorting_val__ = function(b) {
	    a.is.defined(b) && (this.sortValue = this.column.sortValue.call(this.column, b))
	}, a.Cell.extend("define", function(a) {
	    this._super(a), this.__sorting_define__(a)
	}), a.Cell.extend("val", function(a) {
	    var b = this._super(a);
	    return this.__sorting_val__(a), b
	})
  }(FooTable),
  function(a, b) {
	b.Column.prototype.direction = null, b.Column.prototype.sortable = !0, b.Column.prototype.sorted = !1, b.Column.prototype.sorter = function(a, b) {
	    return "string" == typeof a && (a = a.toLowerCase()), "string" == typeof b && (b = b.toLowerCase()), a === b ? 0 : b > a ? -1 : 1
	}, b.Column.prototype.sortValue = function(c) {
	    if (b.is.element(c) || b.is.jq(c)) {
		  var d = a(c).data("sortValue");
		  return b.is.defined(d) ? d : this.parser(c)
	    }
	    if (b.is.hash(c) && b.is.hash(c.options)) {
		  if (b.is.string(c.options.sortValue)) return c.options.sortValue;
		  b.is.defined(c.value) && (c = c.value)
	    }
	    return b.is.defined(c) && null != c ? c : null
	}, b.Column.prototype.__sorting_define__ = function(a) {
	    this.sorter = b.checkFnValue(this, a.sorter, this.sorter), this.direction = b.is.type(a.direction, "string") ? b.Sorting.dir(a.direction) : null, this.sortable = b.is["boolean"](a.sortable) ? a.sortable : !0, this.sorted = b.is["boolean"](a.sorted) ? a.sorted : !1, this.sortValue = b.checkFnValue(this, a.sortValue, this.sortValue)
	}, b.Column.extend("define", function(a) {
	    this._super(a), this.__sorting_define__(a)
	})
  }(jQuery, FooTable),
  function(a) {
	a.Defaults.prototype.sorting = {
	    enabled: !1
	}
  }(FooTable),
  function(a, b) {
	b.HTMLColumn.extend("__sorting_define__", function(c) {
	    this._super(c), this.sortUse = b.is.string(c.sortUse) && -1 !== a.inArray(c.sortUse, ["html", "text"]) ? c.sortUse : "html"
	}), b.HTMLColumn.prototype.sortValue = function(c) {
	    if (b.is.element(c) || b.is.jq(c)) {
		  var d = a(c).data("sortValue");
		  return b.is.defined(d) ? d : a.trim(a(c)[this.sortUse]())
	    }
	    if (b.is.hash(c) && b.is.hash(c.options)) {
		  if (b.is.string(c.options.sortValue)) return c.options.sortValue;
		  b.is.defined(c.value) && (c = c.value)
	    }
	    return b.is.defined(c) && null != c ? c : null
	}
  }(jQuery, FooTable),
  function(a) {
	a.Table.prototype.sort = function(b, c) {
	    return this.use(a.Sorting).sort(b, c)
	}
  }(FooTable),
  function(a, b) {
	b.Pager = b.Class.extend({
	    construct: function(a, b, c, d, e) {
		  this.total = a, this.current = b, this.size = c, this.page = d, this.forward = e
	    }
	})
  }(jQuery, FooTable),
  function(a, b) {
	b.Paging = b.Component.extend({
	    construct: function(a) {
		  this._super(a, a.o.paging.enabled), this.strings = a.o.paging.strings, this.current = a.o.paging.current, this.size = a.o.paging.size, this.limit = a.o.paging.limit, this.position = a.o.paging.position, this.countFormat = a.o.paging.countFormat, this.total = -1, this.totalRows = 0, this.previous = -1, this.formattedCount = null, this.$row = null, this.$cell = null, this.$pagination = null, this.$count = null, this.detached = !0, this._createdLinks = 0
	    },
	    preinit: function(a) {
		  var c = this;
		  this.ft.raise("preinit.ft.paging", [a]).then(function() {
			c.ft.$el.hasClass("footable-paging") && (c.enabled = !0), c.enabled = b.is["boolean"](a.paging) ? a.paging : c.enabled, c.enabled && (c.size = b.is.number(a.pagingSize) ? a.pagingSize : c.size, c.current = b.is.number(a.pagingCurrent) ? a.pagingCurrent : c.current, c.limit = b.is.number(a.pagingLimit) ? a.pagingLimit : c.limit, c.ft.$el.hasClass("footable-paging-left") && (c.position = "left"), c.ft.$el.hasClass("footable-paging-center") && (c.position = "center"), c.ft.$el.hasClass("footable-paging-right") && (c.position = "right"), c.position = b.is.string(a.pagingPosition) ? a.pagingPosition : c.position, c.countFormat = b.is.string(a.pagingCountFormat) ? a.pagingCountFormat : c.countFormat, c.total = Math.ceil(c.ft.rows.all.length / c.size))
		  }, function() {
			c.enabled = !1
		  })
	    },
	    init: function() {
		  var a = this;
		  this.ft.raise("init.ft.paging").then(function() {
			a.$create()
		  }, function() {
			a.enabled = !1
		  })
	    },
	    destroy: function() {
		  var a = this;
		  this.ft.raise("destroy.ft.paging").then(function() {
			a.ft.$el.removeClass("footable-paging").find("tfoot > tr.footable-paging").remove(), a.detached = !0, a._createdLinks = 0
		  })
	    },
	    predraw: function() {
		  this.total = Math.ceil(this.ft.rows.array.length / this.size), this.current = this.current > this.total ? this.total : this.current < 1 ? 1 : this.current, this.totalRows = this.ft.rows.array.length, this.totalRows > this.size && (this.ft.rows.array = this.ft.rows.array.splice((this.current - 1) * this.size, this.size)), this.formattedCount = this.format(this.countFormat)
	    },
	    draw: function() {
		  if (this.total <= 1) this.detached || (this.$row.detach(), this.detached = !0);
		  else {
			if (this.detached) {
			    var b = this.ft.$el.children("tfoot");
			    0 == b.length && (b = a("<tfoot/>"), this.ft.$el.append(b)), this.$row.appendTo(b), this.detached = !1
			}
			this.$cell.attr("colspan", this.ft.columns.visibleColspan), this._createLinks(), this._setVisible(this.current, this.current > this.previous), this._setNavigation(!0), this.$count.text(this.formattedCount)
		  }
	    },
	    $create: function() {
		  this._createdLinks = 0;
		  var b = "footable-paging-center";
		  switch (this.position) {
			case "left":
			    b = "footable-paging-left";
			    break;
			case "right":
			    b = "footable-paging-right"
		  }
		  this.ft.$el.addClass("footable-paging").addClass(b), this.$cell = a("<td/>").attr("colspan", this.ft.columns.visibleColspan);
		  var c = this.ft.$el.children("tfoot");
		  0 == c.length && (c = a("<tfoot/>"), this.ft.$el.append(c)), this.$row = a("<tr/>", {
			"class": "footable-paging"
		  }).append(this.$cell).appendTo(c), this.$pagination = a("<ul/>", {
			"class": "pagination float-right margin-0"
		  }).on("click.footable", "a.footable-page-link", {
			self: this
		  }, this._onPageClicked), this.$count = a("<span/>", {
			"class": "label label-default float-left"
		  }), this.$cell.append(this.$pagination, a("<div/>", {
			"class": "divider"
		  }), this.$count), this.detached = !1
	    },
	    format: function(a) {
		  var b = this.size * (this.current - 1) + 1,
			c = this.size * this.current;
		  return 0 == this.ft.rows.array.length ? (b = 0, c = 0) : c = c > this.totalRows ? this.totalRows : c, a.replace(/\{CP}/g, this.current).replace(/\{TP}/g, this.total).replace(/\{PF}/g, b).replace(/\{PL}/g, c).replace(/\{TR}/g, this.totalRows)
	    },
	    first: function() {
		  return this._set(1)
	    },
	    prev: function() {
		  return this._set(this.current - 1 > 0 ? this.current - 1 : 1)
	    },
	    next: function() {
		  return this._set(this.current + 1 < this.total ? this.current + 1 : this.total)
	    },
	    last: function() {
		  return this._set(this.total)
	    },
	    "goto": function(a) {
		  return this._set(a > this.total ? this.total : 1 > a ? 1 : a)
	    },
	    prevPages: function() {
		  var a = this.$pagination.children("li.footable-page.visible:first").data("page") - 1;
		  this._setVisible(a, !0), this._setNavigation(!1)
	    },
	    nextPages: function() {
		  var a = this.$pagination.children("li.footable-page.visible:last").data("page") + 1;
		  this._setVisible(a, !1), this._setNavigation(!1)
	    },
	    pageSize: function(a) {
		  return b.is.number(a) ? (this.size = a, this.total = Math.ceil(this.ft.rows.all.length / this.size), b.is.jq(this.$row) && this.$row.remove(), this.$create(), void this.ft.draw()) : this.size
	    },
	    _set: function(c) {
		  var d = this,
			e = new b.Pager(d.total, d.current, d.size, c, c > d.current);
		  return d.ft.raise("before.ft.paging", [e]).then(function() {
			return e.page = e.page > e.total ? e.total : e.page, e.page = e.page < 1 ? 1 : e.page, d.current == c ? a.when() : (d.previous = d.current, d.current = e.page, d.ft.draw().then(function() {
			    d.ft.raise("after.ft.paging", [e])
			}))
		  })
	    },
	    _createLinks: function() {
		  if (this._createdLinks !== this.total) {
			var b = this,
			    c = b.total > 1,
			    d = function(b, c, d) {
				  return a("<li/>", {
					"class": d
				  }).attr("data-page", b).append(a("<a/>", {
					"class": "footable-page-link",
					href: "#"
				  }).data("page", b).html(c))
			    };
			b.$pagination.empty(), c && (b.$pagination.append(d("first", b.strings.first, "footable-page-nav")), b.$pagination.append(d("prev", b.strings.prev, "footable-page-nav")), b.limit > 0 && b.limit < b.total && b.$pagination.append(d("prev-limit", b.strings.prevPages, "footable-page-nav")));
			for (var e, f = 0; f < b.total; f++) e = d(f + 1, f + 1, "footable-page"), b.$pagination.append(e);
			c && (b.limit > 0 && b.limit < b.total && b.$pagination.append(d("next-limit", b.strings.nextPages, "footable-page-nav")), b.$pagination.append(d("next", b.strings.next, "footable-page-nav")), b.$pagination.append(d("last", b.strings.last, "footable-page-nav"))), b._createdLinks = b.total
		  }
	    },
	    _setNavigation: function(a) {
		  1 == this.current ? this.$pagination.children('li[data-page="first"],li[data-page="prev"]').addClass("disabled") : this.$pagination.children('li[data-page="first"],li[data-page="prev"]').removeClass("disabled"), this.current == this.total ? this.$pagination.children('li[data-page="next"],li[data-page="last"]').addClass("disabled") : this.$pagination.children('li[data-page="next"],li[data-page="last"]').removeClass("disabled"), 1 == (this.$pagination.children("li.footable-page.visible:first").data("page") || 1) ? this.$pagination.children('li[data-page="prev-limit"]').addClass("disabled") : this.$pagination.children('li[data-page="prev-limit"]').removeClass("disabled"), (this.$pagination.children("li.footable-page.visible:last").data("page") || this.limit) == this.total ? this.$pagination.children('li[data-page="next-limit"]').addClass("disabled") : this.$pagination.children('li[data-page="next-limit"]').removeClass("disabled"), this.limit > 0 && this.total < this.limit ? this.$pagination.children('li[data-page="prev-limit"],li[data-page="next-limit"]').css("display", "none") : this.$pagination.children('li[data-page="prev-limit"],li[data-page="next-limit"]').css("display", ""), a && this.$pagination.children("li.footable-page").removeClass("active").filter('li[data-page="' + this.current + '"]').addClass("active")
	    },
	    _setVisible: function(a, b) {
		  if (this.limit > 0 && this.total > this.limit) {
			if (!this.$pagination.children('li.footable-page[data-page="' + a + '"]').hasClass("visible")) {
			    var c = 0,
				  d = 0;
			    1 == b ? (d = a > this.total ? this.total : a, c = d - this.limit) : (c = 1 > a ? 0 : a - 1, d = c + this.limit), 0 > c && (c = 0, d = this.limit > this.total ? this.total : this.limit), d > this.total && (d = this.total, c = this.total - this.limit < 0 ? 0 : this.total - this.limit), this.$pagination.children("li.footable-page").removeClass("visible").slice(c, d).addClass("visible")
			}
		  } else this.$pagination.children("li.footable-page").removeClass("visible").slice(0, this.total).addClass("visible")
	    },
	    _onPageClicked: function(b) {
		  if (b.preventDefault(), !a(b.target).closest("li").is(".active,.disabled")) {
			var c = b.data.self,
			    d = a(this).data("page");
			switch (d) {
			    case "first":
				  return void c.first();
			    case "prev":
				  return void c.prev();
			    case "next":
				  return void c.next();
			    case "last":
				  return void c.last();
			    case "prev-limit":
				  return void c.prevPages();
			    case "next-limit":
				  return void c.nextPages();
			    default:
				  return void c._set(d)
			}
		  }
	    }
	}), b.components.register("paging", b.Paging, 400)
  }(jQuery, FooTable),
  function(a) {
	a.Defaults.prototype.paging = {
	    enabled: !1,
	    countFormat: "{CP} of {TP}",
	    current: 1,
	    limit: 5,
	    position: "center",
	    size: 10,
	    strings: {
		  first: "&laquo;",
		  prev: "&lsaquo;",
		  next: "&rsaquo;",
		  last: "&raquo;",
		  prevPages: "...",
		  nextPages: "..."
	    }
	}
  }(FooTable),
  function(a) {
	a.Table.prototype.gotoPage = function(b) {
	    return this.use(a.Paging)["goto"](b)
	}, a.Table.prototype.nextPage = function() {
	    return this.use(a.Paging).next()
	}, a.Table.prototype.prevPage = function() {
	    return this.use(a.Paging).prev()
	}, a.Table.prototype.firstPage = function() {
	    return this.use(a.Paging).first()
	}, a.Table.prototype.lastPage = function() {
	    return this.use(a.Paging).last()
	}, a.Table.prototype.nextPages = function() {
	    return this.use(a.Paging).nextPages()
	}, a.Table.prototype.prevPages = function() {
	    return this.use(a.Paging).prevPages()
	}, a.Table.prototype.pageSize = function(b) {
	    return this.use(a.Paging).pageSize(b)
	}
  }(FooTable),
  function(a, b) {
	b.Editing = b.Component.extend({
	    construct: function(c) {
		  this._super(c, c.o.editing.enabled), this.pageToNew = c.o.editing.pageToNew, this.alwaysShow = c.o.editing.alwaysShow, this.column = a.extend(!0, {}, c.o.editing.column, {
			    visible: this.alwaysShow
			}), this.position = c.o.editing.position, this.showText = c.o.editing.showText, this.hideText = c.o.editing.hideText, this.addText = c.o.editing.addText, this.editText = c.o.editing.editText, this.deleteText = c.o.editing.deleteText, this.viewText = c.o.editing.viewText, this.allowAdd = c.o.editing.allowAdd, this.allowEdit = c.o.editing.allowEdit, this.allowDelete = c.o.editing.allowDelete,
			this.allowView = c.o.editing.allowView, this._$buttons = null, this.callbacks = {
			    addRow: b.checkFnValue(this, c.o.editing.addRow),
			    editRow: b.checkFnValue(this, c.o.editing.editRow),
			    deleteRow: b.checkFnValue(this, c.o.editing.deleteRow),
			    viewRow: b.checkFnValue(this, c.o.editing.viewRow)
			}
	    },
	    preinit: function(c) {
		  var d = this;
		  this.ft.raise("preinit.ft.editing", [c]).then(function() {
			if (d.ft.$el.hasClass("footable-editing") && (d.enabled = !0), d.enabled = b.is["boolean"](c.editing) ? c.editing : d.enabled, d.enabled) {
			    if (d.pageToNew = b.is["boolean"](c.editingPageToNew) ? c.editingPageToNew : d.pageToNew, d.alwaysShow = b.is["boolean"](c.editingAlwaysShow) ? c.editingAlwaysShow : d.alwaysShow, d.position = b.is.string(c.editingPosition) ? c.editingPosition : d.position, d.showText = b.is.string(c.editingShowText) ? c.editingShowText : d.showText, d.hideText = b.is.string(c.editingHideText) ? c.editingHideText : d.hideText, d.addText = b.is.string(c.editingAddText) ? c.editingAddText : d.addText, d.editText = b.is.string(c.editingEditText) ? c.editingEditText : d.editText, d.deleteText = b.is.string(c.editingDeleteText) ? c.editingDeleteText : d.deleteText, d.viewText = b.is.string(c.editingViewText) ? c.editingViewText : d.viewText, d.allowAdd = b.is["boolean"](c.editingAllowAdd) ? c.editingAllowAdd : d.allowAdd, d.allowEdit = b.is["boolean"](c.editingAllowEdit) ? c.editingAllowEdit : d.allowEdit, d.allowDelete = b.is["boolean"](c.editingAllowDelete) ? c.editingAllowDelete : d.allowDelete, d.allowView = b.is["boolean"](c.editingAllowView) ? c.editingAllowView : d.allowView, d.column = new b.EditingColumn(d.ft, d, a.extend(!0, {}, d.column, c.editingColumn, {
					visible: d.alwaysShow
				  })), d.ft.$el.hasClass("footable-editing-left") && (d.position = "left"), d.ft.$el.hasClass("footable-editing-right") && (d.position = "right"), "right" === d.position) d.column.index = d.ft.columns.array.length;
			    else {
				  d.column.index = 0;
				  for (var e = 0, f = d.ft.columns.array.length; f > e; e++) d.ft.columns.array[e].index += 1
			    }
			    d.ft.columns.array.push(d.column), d.ft.columns.array.sort(function(a, b) {
				  return a.index - b.index
			    }), d.callbacks.addRow = b.checkFnValue(d, c.editingAddRow, d.callbacks.addRow), d.callbacks.editRow = b.checkFnValue(d, c.editingEditRow, d.callbacks.editRow), d.callbacks.deleteRow = b.checkFnValue(d, c.editingDeleteRow, d.callbacks.deleteRow), d.callbacks.viewRow = b.checkFnValue(d, c.editingViewRow, d.callbacks.viewRow)
			}
		  }, function() {
			d.enabled = !1
		  })
	    },
	    init: function() {
		  var a = this;
		  this.ft.raise("init.ft.editing").then(function() {
			a.$create()
		  }, function() {
			a.enabled = !1
		  })
	    },
	    destroy: function() {
		  var a = this;
		  this.ft.raise("destroy.ft.editing").then(function() {
			a.ft.$el.removeClass("footable-editing footable-editing-always-show footable-editing-no-add footable-editing-no-edit footable-editing-no-delete footable-editing-no-view").off("click.ft.editing").find("tfoot > tr.footable-editing").remove()
		  })
	    },
	    $create: function() {
		  var b = this,
			c = "right" === b.position ? "footable-editing-right" : "footable-editing-left";
		  b.ft.$el.addClass("footable-editing").addClass(c).on("click.ft.editing", ".footable-show", {
			self: b
		  }, b._onShowClick).on("click.ft.editing", ".footable-hide", {
			self: b
		  }, b._onHideClick).on("click.ft.editing", ".footable-edit", {
			self: b
		  }, b._onEditClick).on("click.ft.editing", ".footable-delete", {
			self: b
		  }, b._onDeleteClick).on("click.ft.editing", ".footable-view", {
			self: b
		  }, b._onViewClick).on("click.ft.editing", ".footable-add", {
			self: b
		  }, b._onAddClick), b.$cell = a("<td/>").attr("colspan", b.ft.columns.visibleColspan).append(b.$buttonShow()), b.allowAdd && b.$cell.append(b.$buttonAdd()), b.$cell.append(b.$buttonHide()), b.alwaysShow && b.ft.$el.addClass("footable-editing-always-show"), b.allowAdd || b.ft.$el.addClass("footable-editing-no-add"), b.allowEdit || b.ft.$el.addClass("footable-editing-no-edit"), b.allowDelete || b.ft.$el.addClass("footable-editing-no-delete"), b.allowView || b.ft.$el.addClass("footable-editing-no-view");
		  var d = b.ft.$el.children("tfoot");
		  0 == d.length && (d = a("<tfoot/>"), b.ft.$el.append(d)), b.$row = a("<tr/>", {
			"class": "footable-editing"
		  }).append(b.$cell).appendTo(d)
	    },
	    $buttonShow: function() {
		  return '<button type="button" class="btn btn-primary footable-show">' + this.showText + "</button>"
	    },
	    $buttonHide: function() {
		  return '<button type="button" class="btn btn-default footable-hide">' + this.hideText + "</button>"
	    },
	    $buttonAdd: function() {
		  return '<button type="button" class="btn btn-primary footable-add">' + this.addText + "</button> "
	    },
	    $buttonEdit: function() {
		  return '<button type="button" class="btn btn-default footable-edit">' + this.editText + "</button> "
	    },
	    $buttonDelete: function() {
		  return '<button type="button" class="btn btn-default footable-delete">' + this.deleteText + "</button>"
	    },
	    $buttonView: function() {
		  return '<button type="button" class="btn btn-default footable-view">' + this.viewText + "</button> "
	    },
	    $rowButtons: function() {
		  return b.is.jq(this._$buttons) ? this._$buttons.clone() : (this._$buttons = a('<div class="btn-group btn-group-xs" role="group"></div>'), this.allowView && this._$buttons.append(this.$buttonView()), this.allowEdit && this._$buttons.append(this.$buttonEdit()), this.allowDelete && this._$buttons.append(this.$buttonDelete()), this._$buttons)
	    },
	    draw: function() {
		  this.$cell.attr("colspan", this.ft.columns.visibleColspan)
	    },
	    _onEditClick: function(c) {
		  c.preventDefault();
		  var d = c.data.self,
			e = a(this).closest("tr").data("__FooTableRow__");
		  e instanceof b.Row && d.ft.raise("edit.ft.editing", [e]).then(function() {
			d.callbacks.editRow.call(d.ft, e)
		  })
	    },
	    _onDeleteClick: function(c) {
		  c.preventDefault();
		  var d = c.data.self,
			e = a(this).closest("tr").data("__FooTableRow__");
		  e instanceof b.Row && d.ft.raise("delete.ft.editing", [e]).then(function() {
			d.callbacks.deleteRow.call(d.ft, e)
		  })
	    },
	    _onViewClick: function(c) {
		  c.preventDefault();
		  var d = c.data.self,
			e = a(this).closest("tr").data("__FooTableRow__");
		  e instanceof b.Row && d.ft.raise("view.ft.editing", [e]).then(function() {
			d.callbacks.viewRow.call(d.ft, e)
		  })
	    },
	    _onAddClick: function(a) {
		  a.preventDefault();
		  var b = a.data.self;
		  b.ft.raise("add.ft.editing").then(function() {
			b.callbacks.addRow.call(b.ft)
		  })
	    },
	    _onShowClick: function(a) {
		  a.preventDefault();
		  var b = a.data.self;
		  b.ft.raise("show.ft.editing").then(function() {
			b.ft.$el.addClass("footable-editing-show"), b.column.visible = !0, b.ft.draw()
		  })
	    },
	    _onHideClick: function(a) {
		  a.preventDefault();
		  var b = a.data.self;
		  b.ft.raise("hide.ft.editing").then(function() {
			b.ft.$el.removeClass("footable-editing-show"), b.column.visible = !1, b.ft.draw()
		  })
	    }
	}), b.components.register("editing", b.Editing, 850)
  }(jQuery, FooTable),
  function(a, b) {
	b.EditingColumn = b.Column.extend({
	    construct: function(a, b, c) {
		  this._super(a, c, "editing"), this.editing = b
	    },
	    $create: function() {
		  (this.$el = !this.virtual && b.is.jq(this.$el) ? this.$el : a("<th/>", {
			"class": "footable-editing"
		  })).html(this.title)
	    },
	    parser: function(c) {
		  if (b.is.string(c) && (c = a(a.trim(c))), b.is.element(c) && (c = a(c)), b.is.jq(c)) {
			var d = c.prop("tagName").toLowerCase();
			return "td" == d || "th" == d ? c.data("value") || c.contents() : c
		  }
		  return null
	    },
	    createCell: function(c) {
		  var d = this.editing.$rowButtons(),
			e = a("<td/>").append(d);
		  return b.is.jq(c.$el) && (0 === this.index ? e.prependTo(c.$el) : e.insertAfter(c.$el.children().eq(this.index - 1))), new b.Cell(this.ft, c, this, e || e.html())
	    }
	}), b.columns.register("editing", b.EditingColumn)
  }(jQuery, FooTable),
  function(a, b) {
	b.Defaults.prototype.editing = {
	    enabled: !1,
	    pageToNew: !0,
	    position: "right",
	    alwaysShow: !1,
	    addRow: function() {},
	    editRow: function(a) {},
	    deleteRow: function(a) {},
	    viewRow: function(a) {},
	    showText: '<span class="fooicon fooicon-pencil" aria-hidden="true"></span> Edit rows',
	    hideText: "Cancel",
	    addText: "New row",
	    editText: '<span class="fooicon fooicon-pencil" aria-hidden="true"></span>',
	    deleteText: '<span class="fooicon fooicon-trash" aria-hidden="true"></span>',
	    viewText: '<span class="fooicon fooicon-stats" aria-hidden="true"></span>',
	    allowAdd: !0,
	    allowEdit: !0,
	    allowDelete: !0,
	    allowView: !1,
	    column: {
		  classes: "footable-editing",
		  name: "editing",
		  title: "",
		  filterable: !1,
		  sortable: !1
	    }
	}
  }(jQuery, FooTable),
  function(a, b) {
	b.is.defined(b.Paging) && (b.Paging.prototype.unpaged = [], b.Paging.extend("predraw", function() {
	    this.unpaged = this.ft.rows.array.slice(0), this._super()
	}))
  }(jQuery, FooTable),
  function(a, b) {
	b.Row.prototype.add = function(c) {
	    c = b.is["boolean"](c) ? c : !0;
	    var d = this;
	    return a.Deferred(function(a) {
		  var b = d.ft.rows.all.push(d) - 1;
		  return c ? d.ft.draw().then(function() {
			a.resolve(b)
		  }) : void a.resolve(b)
	    })
	}, b.Row.prototype["delete"] = function(c) {
	    c = b.is["boolean"](c) ? c : !0;
	    var d = this;
	    return a.Deferred(function(a) {
		  var e = d.ft.rows.all.indexOf(d);
		  return b.is.number(e) && e >= 0 && e < d.ft.rows.all.length && (d.ft.rows.all.splice(e, 1), c) ? d.ft.draw().then(function() {
			a.resolve(d)
		  }) : void a.resolve(d)
	    })
	}, b.is.defined(b.Paging) && b.Row.extend("add", function(a) {
	    a = b.is["boolean"](a) ? a : !0;
	    var c, d = this,
		  e = this._super(a),
		  f = d.ft.use(b.Editing);
	    return f && f.pageToNew && (c = d.ft.use(b.Paging)) && a ? e.then(function() {
		  var a = c.unpaged.indexOf(d),
			b = Math.ceil((a + 1) / c.size);
		  return c.current !== b ? c["goto"](b) : void 0
	    }) : e
	}), b.is.defined(b.Sorting) && b.Row.extend("val", function(a, c) {
	    c = b.is["boolean"](c) ? c : !0;
	    var d = this._super(a);
	    if (!b.is.hash(a)) return d;
	    var e = this;
	    return c && e.ft.draw().then(function() {
		  var a, c = e.ft.use(b.Editing);
		  if (b.is.defined(b.Paging) && c && c.pageToNew && (a = e.ft.use(b.Paging))) {
			var d = a.unpaged.indexOf(e),
			    f = Math.ceil((d + 1) / a.size);
			if (a.current !== f) return a["goto"](f)
		  }
	    }), d
	})
  }(jQuery, FooTable),
  function(a) {
	a.Rows.prototype.add = function(b, c) {
	    var d = b;
	    a.is.hash(b) && (d = new FooTable.Row(this.ft, this.ft.columns.array, b)), d instanceof FooTable.Row && d.add(c)
	}, a.Rows.prototype.update = function(b, c, d) {
	    var e = this.ft.rows.all.length,
		  f = b;
	    a.is.number(b) && b >= 0 && e > b && (f = this.ft.rows.all[b]), f instanceof FooTable.Row && a.is.hash(c) && f.val(c, d)
	}, a.Rows.prototype["delete"] = function(b, c) {
	    var d = this.ft.rows.all.length,
		  e = b;
	    a.is.number(b) && b >= 0 && d > b && (e = this.ft.rows.all[b]), e instanceof FooTable.Row && e["delete"](c)
	}
  }(FooTable),
  function(a, b) {
	var c = 0,
	    d = function(a) {
		  var b, c, d = 2166136261;
		  for (b = 0, c = a.length; c > b; b++) d ^= a.charCodeAt(b), d += (d << 1) + (d << 4) + (d << 7) + (d << 8) + (d << 24);
		  return d >>> 0
	    }(location.origin + location.pathname);
	b.State = b.Component.extend({
	    construct: function(a) {
		  this._super(a, a.o.state.enabled), this._key = "1", this.key = this._key + (b.is.string(a.o.state.key) ? a.o.state.key : this._uid()), this.filtering = b.is["boolean"](a.o.state.filtering) ? a.o.state.filtering : !0, this.paging = b.is["boolean"](a.o.state.paging) ? a.o.state.paging : !0, this.sorting = b.is["boolean"](a.o.state.sorting) ? a.o.state.sorting : !0
	    },
	    preinit: function(a) {
		  var c = this;
		  this.ft.raise("preinit.ft.state", [a]).then(function() {
			c.enabled = b.is["boolean"](a.state) ? a.state : c.enabled, c.enabled && (c.key = c._key + (b.is.string(a.stateKey) ? a.stateKey : c.key), c.filtering = b.is["boolean"](a.stateFiltering) ? a.stateFiltering : c.filtering, c.paging = b.is["boolean"](a.statePaging) ? a.statePaging : c.paging, c.sorting = b.is["boolean"](a.stateSorting) ? a.stateSorting : c.sorting)
		  }, function() {
			c.enabled = !1
		  })
	    },
	    get: function(a) {
		  return JSON.parse(localStorage.getItem(this.key + ":" + a))
	    },
	    set: function(a, b) {
		  localStorage.setItem(this.key + ":" + a, JSON.stringify(b))
	    },
	    remove: function(a) {
		  localStorage.removeItem(this.key + ":" + a)
	    },
	    read: function() {
		  this.ft.execute(!1, !0, "readState")
	    },
	    write: function() {
		  this.ft.execute(!1, !0, "writeState")
	    },
	    clear: function() {
		  this.ft.execute(!1, !0, "clearState")
	    },
	    _uid: function() {
		  var a = this.ft.$el.attr("id");
		  return d + "_" + (b.is.string(a) ? a : ++c)
	    }
	}), b.components.register("state", b.State, 700)
  }(jQuery, FooTable),
  function(a) {
	a.Component.prototype.readState = function() {}, a.Component.prototype.writeState = function() {}, a.Component.prototype.clearState = function() {}
  }(FooTable),
  function(a) {
	a.Defaults.prototype.state = {
	    enabled: !1,
	    filtering: !0,
	    paging: !0,
	    sorting: !0,
	    key: null
	}
  }(FooTable),
  function(a) {
	a.Filtering && (a.Filtering.prototype.readState = function() {
	    if (this.ft.state.filtering) {
		  var b = this.ft.state.get("filtering");
		  a.is.hash(b) && !a.is.emptyArray(b.filters) && (this.filters = this.ensure(b.filters))
	    }
	}, a.Filtering.prototype.writeState = function() {
	    if (this.ft.state.filtering) {
		  var b = a.arr.map(this.filters, function(b) {
			return {
			    name: b.name,
			    query: b.query instanceof a.Query ? b.query.val() : b.query,
			    columns: a.arr.map(b.columns, function(a) {
				  return a.name
			    }),
			    hidden: b.hidden,
			    space: b.space,
			    connectors: b.connectors,
			    ignoreCase: b.ignoreCase
			}
		  });
		  this.ft.state.set("filtering", {
			filters: b
		  })
	    }
	}, a.Filtering.prototype.clearState = function() {
	    this.ft.state.filtering && this.ft.state.remove("filtering")
	})
  }(FooTable),
  function(a) {
	a.Paging && (a.Paging.prototype.readState = function() {
	    if (this.ft.state.paging) {
		  var b = this.ft.state.get("paging");
		  a.is.hash(b) && (this.current = b.current, this.size = b.size)
	    }
	}, a.Paging.prototype.writeState = function() {
	    this.ft.state.paging && this.ft.state.set("paging", {
		  current: this.current,
		  size: this.size
	    })
	}, a.Paging.prototype.clearState = function() {
	    this.ft.state.paging && this.ft.state.remove("paging")
	})
  }(FooTable),
  function(a) {
	a.Sorting && (a.Sorting.prototype.readState = function() {
	    if (this.ft.state.sorting) {
		  var b = this.ft.state.get("sorting");
		  if (a.is.hash(b)) {
			var c = this.ft.columns.get(b.column);
			c instanceof a.Column && (this.column = c, this.column.direction = b.direction)
		  }
	    }
	}, a.Sorting.prototype.writeState = function() {
	    this.ft.state.sorting && this.column instanceof a.Column && this.ft.state.set("sorting", {
		  column: this.column.name,
		  direction: this.column.direction
	    })
	}, a.Sorting.prototype.clearState = function() {
	    this.ft.state.sorting && this.ft.state.remove("sorting")
	})
  }(FooTable),
  function(a) {
	a.Table.extend("_construct", function(a) {
	    this.state = this.use(FooTable.State), this._super(a)
	}), a.Table.extend("_preinit", function() {
	    var a = this;
	    return a._super().then(function() {
		  a.state.enabled && a.state.read()
	    })
	}), a.Table.extend("draw", function() {
	    var a = this;
	    return a._super().then(function() {
		  a.state.enabled && a.state.write()
	    })
	})
  }(FooTable);