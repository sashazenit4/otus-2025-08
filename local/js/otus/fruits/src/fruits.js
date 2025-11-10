import { BitrixVue } from 'ui.vue3';
import type { Params, Fruit} from './types';

export class Fruits
{
	constructor(params: Params)
	{
		BitrixVue.createApp({
			props: {
				fruits: {
					type: Array,
					required: true
				}
			},
			template: 
			'<ol class="fruits">' +
				'<template v-for="fruit of fruits" :key="fruit.name">\n' +
					'<li class="fruit">\n' +
						'<img width="50px" :src="fruit.img"/>\n' +
						'<span>{{ fruit.name }}</span>\n' +
					'</li>\n' +
				'</template>' +
			'</ol>',
		}, params).mount(params.container);
	}
}
