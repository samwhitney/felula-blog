<div>
	<div class="w-3/4">
		<ul class="space-y-5 mb-5">
			@foreach($posts as $post)
				<article class="flex gap-4 p-6 shadow hover:shadow-lg transition rounded-lg bg-white">
					@if(isset($post['image']))
						<figure class="flex w-40 h-40 rounded-lg object-contain overflow-hidden">
							<image src="{{asset('storage/' . $post['image']) }}" alt="{{ $post['title'] }}" class="object-cover h-full"/>
						</figure>
					@endif
					<div class="flex-1 space-y-3">
						<h2 class="font-semibold font-playfair text-2xl text-slate-700">{{ $post['title'] }}</h2>
						<div class="text-slate-500">
							{!! Str::limit(strip_tags($post['content']), 200, '...') !!}
						</div>
						<div class="flex justify-between items-center">
							<p class="font-semibold text-slate-400 space-x-4 text-sm">
								<span class="text-orange-500">{{ date("F jS, Y", strtotime($post['created_at'])) }}</span>
								<span>|</span>
								<span>By {{ $post['author']['name'] }}</span>
							</p>
							<x-button-link href="{{ route('article', ['post' => $post['slug']]) }}" format="frontend">View Article</x-button-link>
						</div>
					</div>
				</article>
			@endforeach	
		</ul>
		{{ $posts->links() }}
	</div>
</div> 