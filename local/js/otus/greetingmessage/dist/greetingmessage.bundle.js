/* eslint-disable */
this.BX = this.BX || {};
(function (exports,main_core) {
	'use strict';

	var Greetingmessage = /*#__PURE__*/function () {
	  function Greetingmessage() {
	    var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {
	      name: 'Greetingmessage'
	    };
	    babelHelpers.classCallCheck(this, Greetingmessage);
	    this.name = options.name;
	  }
	  babelHelpers.createClass(Greetingmessage, [{
	    key: "setName",
	    value: function setName(name) {
	      if (main_core.Type.isString(name)) {
	        this.name = name;
	      }
	    }
	  }, {
	    key: "getName",
	    value: function getName() {
	      return this.name;
	    }
	  }, {
	    key: "helloWorld",
	    value: function helloWorld() {
	      alert('Hello world!');
	    }
	  }]);
	  return Greetingmessage;
	}();

	exports.Greetingmessage = Greetingmessage;

}((this.BX.Otus = this.BX.Otus || {}),BX));
