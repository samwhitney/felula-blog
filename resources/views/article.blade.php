<x-blog-layout>
	<article class="w-3/4 bg-white p-6 shadow rounded-lg">
		@if(isset($post['image']))
			<figure class="flex w-full h-60 mb-4 rounded-lg object-contain overflow-hidden">
				<image src="{{asset('storage/' . $post['image']) }}" alt="{{ $post['title'] }}" class="object-cover w-full"/>
			</figure>
		@endif
		<header class="mb-4">
			<h2 class="font-semibold font-playfair text-4xl text-slate-700 mb-2">{{ $post['title'] }}</h2>
			<p class="font-semibold text-slate-400 space-x-4">
				<span class="text-orange-500">{{ date("F jS, Y", strtotime($post['created_at'])) }}</span>
				<span>|</span>
				<span>By {{ $post['author']['name'] }}</span>
			</p>
		</header>
		<section class="text-slate-500">
			{!! $post['content'] !!}
		</section>
    	@livewire('comments', [ 'postId' => $post['id'] ])
	</article>
</x-blog-layout>
