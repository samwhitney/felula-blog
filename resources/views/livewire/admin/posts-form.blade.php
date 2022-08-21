<div x-data="">
	<form wire:submit.prevent="submit" class="w-full space-y-4">
		<h2 class="font-semibold leading-tight text-xl text-gray-800">Add New Post</h2>
		<p>
			<x-label for="title">Title</x-label>
			<x-input type="text" id="title" name="title" wire:model="post.title" @change="$wire.setSlug"/>
			@error('post.title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
		</p>
		<p>
			<x-label for="slug">Slug</x-label>
			<x-input type="text" id="slug" name="slug" wire:model="post.slug"/>
			@error('post.slug') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
		</p>

		<div>
			<x-label for="image">Image</x-label>
			@if($post['image'])
				<x-button wire:click="removeImage" type="button" format="danger">Remove Image</x-button>
			@else
				<input type="file" wire:model="post.image">
			@endif
			@error('post.image') <span class="error">{{ $message }}</span> @enderror
		</div>

		<div>
			<x-label for="content">Content</x-label>
			<div wire:ignore>
                <textarea id="content">{!! $post['content'] !!}</textarea>
				<script>
					// Create instance of CK editor, with limited toolbar options
					ClassicEditor
						.create(document.querySelector('#content'), {
        					toolbar: [ 
								'heading', '|',
								'bold', 'italic', 'link', 'numberedList', 'bulletedList', '|',
								'insertTable', 'blockQuote', 'mediaEmbed', '|',
								'undo', 'redo', '|'
							]
						})
						.then( editor => {
							// On edit, set livewire data to mirror the changes in CK editor
							editor.model.document.on('change:data', () => {
								@this.set('post.content', editor.getData());
							})
						} )
						.catch( error => {
							console.error( error );
						} );
				</script>
			</div>
			@error('post.content') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
		</div>
		<div>
			<x-label>Enabled?</x-label>
			<input type="checkbox" wire:model="post.enabled" class="w-5 h-5 rounded-sm shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"/>
			@error('post.enabled') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
		</div>

		<p class="space-x-2">
			<x-button type="submit">Save Post</x-button>
			<x-button wire:click="close" format="danger" id="cancel" type="button">Cancel</x-button>
		</p>

	</form>
</div>
