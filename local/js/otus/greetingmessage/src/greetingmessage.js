import {Type} from 'main.core';

export class Greetingmessage
{
	constructor(options = {name: 'Greetingmessage'})
	{
		this.name = options.name;
	}

	setName(name)
	{
		if (Type.isString(name))
		{
			this.name = name;
		}
	}

	getName()
	{
		return this.name;
	}

	helloWorld()
	{
		alert('Hello world!');
	}
}
