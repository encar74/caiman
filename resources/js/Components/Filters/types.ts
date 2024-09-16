export interface Option {
	key: string,
	label?: string
}

export interface Filter {
	key: string,
	title: string;
	options: Array<Option>;
}