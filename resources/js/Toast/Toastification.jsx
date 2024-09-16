import { defineComponent } from 'vue';
import { CheckIcon, XIcon, ExclamationIcon, QuestionMarkCircleIcon } from '@heroicons/vue/outline';
import '@/Toast/style.css';
import Button from '@/Components/Button.vue';

export default defineComponent({
	props: {
		variant: {
			type: String,
			default: 'primary',
			validator(value) {
				return ['primary', 'success', 'warning', 'error', 'info'].includes(value);
			},
		},
		title: {
			type: String,
			default: 'Notification',
		},
		text: {
			type: String,
			default: null,
		},
		hideClose: {
			type: Boolean,
			default: false,
		},
	},

	emits: ['close-toast'],

	setup(props, { emit }) {
		const { variant, title, text, hideClose } = props;

		const iconBackgroundClass = [
			{
				'bg-sky-400': variant == 'primary',
				'bg-green-400': variant == 'success',
				'bg-yellow-400': variant == 'warning',
				'bg-red-400': variant == 'error',
				'bg-cyan-400': variant == 'info',
			},
		];

		const textVariantClass = [
			{
				'text-sky-500': variant == 'primary',
				'text-green-500': variant == 'success',
				'text-yellow-500': variant == 'warning',
				'text-red-500': variant == 'error',
				'text-cyan-500': variant == 'info',
			},
		];

		let Icon;

		switch (variant) {
			case 'primary':
				Icon = CheckIcon;
				break;
			case 'success':
				Icon = CheckIcon;
				break;
			case 'warning':
				Icon = ExclamationIcon;
				break;
			case 'error':
				Icon = XIcon;
				break;
			case 'info':
				Icon = QuestionMarkCircleIcon;
				break;
			case 'prompt':
				Icon = QuestionMarkCircleIcon;
				break;
		}

		const handleClose = () => {
			emit('close-toast');
		};

		return () => (
			<div class={['relative p-4 rounded-md shadow-lg border bg-white dark:bg-dark-400 dark:border-dark-200']}>
				<div class="flex items-start gap-4">
					<span class={['inline-flex p-1 rounded-full', iconBackgroundClass]}>
						<Icon aria-hidden="true" class="w-6 h-6 text-white" />
					</span>

					<Button onClick={handleClose} iconOnly size="sm" variant="secondary" srText="Close notification" class="absolute right-2 top-2">
						{({ iconSizeClasses }) => (
							<>
								<XIcon aria-hidden="true" class={iconSizeClasses} />
							</>
						)}
					</Button>

					<div class="space-y-2">
						<div class={['font-bold', textVariantClass]}>{title}</div>
						<p class="text-gray-600 dark:text-gray-400">{text}</p>
					</div>
				</div>
			</div>
		);
	},
});
