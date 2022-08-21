<div>
	<!-- Page Heading -->
	<header class="bg-white shadow">
		<div class="flex max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
			<h2 class="font-semibold leading-tight text-xl text-gray-800 w-1/2">
				{{ __('Comments') }}
			</h2>
		</div>
	</header>

	<!-- Content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<table class="w-full">
					<thead class="border-b font-medium text-left">
						<tr>
							<th class="px-6 py-4">Guest</th>
							<th colspan="2" class="px-6 py-4">Comment</th>
						</tr>
					</thead>
					<tbody>
						@if($comments->isNotEmpty())
							@foreach($comments as $comment)
								<tr class="border-b even:bg-white odd:bg-slate-100">
									<td class="px-6 py-4">
										{{ $comment['name'] }}<br>
										{{ $comment['email'] }}
									</td>
									<td class="w-1/2 px-6 py-4">{{ $comment['comment'] }}</td>
									<td class="px-6 space-x-2 text-right">
										<x-button-link href="{{ route('admin-posts', ['editId' => $comment['post_id']]) }}">View Post</x-button-link>
										<x-button wire:click="delete({{ $comment['id'] }})" type="button" format="danger">Delete</x-button>
									</td>
								</tr>
							@endforeach
						@else
							<td colspan="5" class="px-6 py-4 text-center bg-slate-100">No Comments Available</td>
						@endif
					</tbody>
				</table>
				<div class="mt-6">
					{{ $comments->links() }}
				</div>
			</div>
		</div>
	</div>
</div>