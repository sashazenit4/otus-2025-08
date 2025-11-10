/* eslint-disable */
this.BX = this.BX || {};
(function (exports,ui_vue3) {
	'use strict';

	var Fruits = function Fruits(params) {
	  babelHelpers.classCallCheck(this, Fruits);
	  ui_vue3.BitrixVue.createApp({
	    props: {
	      fruits: {
	        type: Array,
	        required: true
	      }
	    },
	    template: '<ol class="fruits">' + '<template v-for="fruit of fruits" :key="fruit.name">\n' + '<li class="fruit">\n' + '<img width="50px" :src="fruit.img"/>\n' + '<span>{{ fruit.name }}</span>\n' + '</li>\n' + '</template>' + '</ol>'
	  }, params).mount(params.container);
	};

	exports.Fruits = Fruits;

}((this.BX.Otus = this.BX.Otus || {}),BX.Vue3));
