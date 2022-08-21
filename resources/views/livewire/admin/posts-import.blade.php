<div x-data="{ ...utils }">
	<form wire:submit.prevent="fileImport" class="w-full space-y-4">
		<h2 class="font-semibold leading-tight text-xl text-gray-800">Import CSV File</h2>
		<p @click="csvExample()" class="underline cursor-pointer text-blue-400">Download example CSV file</p>
		<p>
			<x-label for="upload">CSV File</x-label>
			<x-input wire:ignore type="file" @change="csvUpload()" id="upload" />
			@if($error)
				<span class="text-red-600 text-sm">File could not be processed, please check format and try again</span>
			@endif
			@if($errors->any())
				<div class="text-red-600 text-sm">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
		</p>
		<p class="space-x-2">
			<x-button id="submitImport" type="submit">Import Posts</x-button>
			<x-button wire:click="close" format="danger" id="cancel" type="button">Cancel</x-button>
		</p>
	</form>
	<script wire:ignore>
		// Register utilities
		const utils = {
			csvExample(){

				// Build up array of expected headings
				const array =
				[
					{title: "", slug: "", guid: "", content: "", enabled: ""},
				];

				// Unparse array into CSV file
				const csv = Papa.unparse(array);
				const csvData = new Blob([csv], {type: 'text/csv;charset=utf-8;'});
				const csvURL = window.URL.createObjectURL(csvData);

				// Trigger download
				let tempLink = document.createElement('a');
				tempLink.href = csvURL;
				tempLink.setAttribute('download', 'download.csv');
				tempLink.click();
			},

			csvUpload(){

				// Disabled import button
				document.getElementById("submitImport").disabled = true;
						
				// Extract file list from input
				let fileInput = document.getElementById('upload');

				// Parse CSV into json, include headers and set the livewire import data
				Papa.parse(fileInput.files[0], {
					header: true,
					complete: function(results) {
						@this.set('import', results);
					}
				});

				// Enable import button
				document.getElementById("submitImport").disabled = false;

			}
		}
		window.utils = utils
	</script>
</div>
