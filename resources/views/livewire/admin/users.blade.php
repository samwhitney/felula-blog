<div>

	<!-- Page Heading -->
	<header class="bg-white shadow">
		<div class="flex max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
			<h2 class="font-semibold leading-tight text-xl text-gray-800 w-1/2">
				{{ __('Users') }}
			</h2>
			<p class="w-1/2 text-right">
				<x-button wire:click="add" type="button" class="-my-4">Add New</x-button>
			</p>
		</div>
	</header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

					@if($view == 'form')
    					@livewire('admin.users-form', [ 'userId' => $editId ])
					@else
						<table class="w-full">
							<thead class="border-b font-medium text-left">
								<tr>
									<th class="px-6 py-4">#</th>
									<th class="px-6 py-4">Name</th>
									<th colspan="2" class="px-6 py-4">Email</th>
								</tr>
							</thead>
							<tbody>
								@foreach($users as $user)
									<tr class="border-b">
										<td class="px-6 py-4">{{ $user['id'] }}</td>
										<td class="px-6 py-4">{{ $user['name'] }}</td>
										<td class="px-6 py-4">{{ $user['email'] }}</td>
										<td class="space-x-2">
											<x-button wire:click="edit({{ $user['id'] }})" type="button">Edit</x-button>
											@if($user['id'] != auth()->user()->id)
												<x-button wire:click="delete({{ $user['id'] }})" type="button" format="danger">Delete</x-button>
											@endif
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					@endif
				</div>
            </div>
        </div>
    </div>
</div>