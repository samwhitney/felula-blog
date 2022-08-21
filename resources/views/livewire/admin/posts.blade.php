<div x-data="{ modal: false }">

	<!-- Posts Navigation -->
	<header class="bg-white shadow">
		<div class="flex max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
			<h2 class="font-semibold leading-tight text-xl text-gray-800 w-1/2">
				{{ __('Posts') }}
			</h2>
			<p class="w-1/2 text-right space-x-2">
				<x-button @click="$wire.set('view','import')" type="button" class="-my-4">Import CSV</x-button>
				<x-button wire:click="add" type="button" class="-my-4">Add New</x-button>
			</p>
		</div>
	</header>

	<!-- Post Paginated Results -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
				@if($view == 'import')
					@livewire('admin.posts-import')
				@elseif($view == 'form')
    				@livewire('admin.posts-form', [ 'postId' => $editId ])
				@else
					<table class="w-full">
						<thead class="border-b font-medium text-left">
							<tr>
								<th class="px-6 py-4">#</th>
								<th class="px-6 py-4">Title</th>
								<th colspan="2" class="px-6 py-4">Author</th>
							</tr>
						</thead>
						<tbody>
							@if($posts->isNotEmpty())
								@foreach($posts as $post)
									<tr class="border-b even:bg-white odd:bg-slate-100">
										<td class="px-6 py-4">{{ $post['id'] }}</td>
										<td class="w-1/2 px-6 py-4">{{ $post['title'] }}</td>
										<td class="px-6 py-4">{{ $post['author']['name'] }}</td>
										<td class="px-6 space-x-2 text-right">
											<x-button-link href="{{ route('article', ['post' => $post['slug']]) }}" target="_blank" type="button">View</x-button-link>
											<x-button wire:click="edit({{ $post['id'] }})" type="button">Edit</x-button>
											<x-button wire:click="delete({{ $post['id'] }})" type="button" format="danger">Delete</x-button>
										</td>
									</tr>
								@endforeach
							@else
								<td colspan="5" class="px-6 py-4 text-center bg-slate-100">No Posts Available</td>
							@endif
						</tbody>
					</table>
					<div class="mt-6">
						{{ $posts->links() }}
					</div>
				@endif
			</div>
		</div>
	</div>

</div>