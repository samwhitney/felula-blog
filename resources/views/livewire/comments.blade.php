<div x-data="{ show: false }">
	<aside class="mt-8 py-8 border-t">
		<h3 class="font-semibold font-playfair text-2xl text-sky-900 border-b mb-6 pb-3">Comments</h3>
		<form wire:submit.prevent="submit">

			<x-input wire:model="new.comment" type="text" placeholder="Join the conversation" @focus="show=true" class="mb-4" />

			<div x-show="show" x-transition class="grid grid-cols-2 gap-4 mb-4">
				<div class="">
					<x-input wire:model="new.name" type="text" placeholder="name" />
				</div>
				<div class="">
					<x-input wire:model="new.email" type="email" placeholder="Email address" />
				</div>
				<div>
					<x-button type="submit">Submit Comment</x-button>
				</div>
			</div>
		</form>

		<ul class="space-y-5 border-t pt-5">
			@foreach($comments as $comment)
				<li class="flex gap-4 items-start">
					<img src="{{ asset('storage/comment-solid.svg') }}" class="w-5 mt-1"/>
					<article class="flex-1">
						<div class="flex justify-between items-center">
							<h4 class="font-semibold text-slate-700">{{ $comment->name }}</h4>
							<p class="font-bold text-slate-400 text-sm">{{ $comment->created_at->diffForHumans() }}</p>
						</div>
						<p class="text-slate-600 text-sm">{{ $comment->comment }}</p>
					</article>
				</li>
			@endforeach
		</ul>

	</aside>
</div>
