<div>
	<form wire:submit.prevent="submit" class="w-full md:w-1/2 space-y-4">
		<h2 class="font-semibold leading-tight text-xl text-gray-800">Add New User</h2>
		<p>
			<x-label>Name</x-label>
			<x-input type="text" wire:model="name"/>
			@error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
		</p>
		<p>
			<x-label>Email Address</x-label>
			<x-input type="text" wire:model="email"/>
			@error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
		</p>
		<x-button type="submit">Save User</x-button>
	</form>
</div>