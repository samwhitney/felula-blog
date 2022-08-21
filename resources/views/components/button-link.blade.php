@props(['format' => 'primary'])
@php
	// Build default class
	$class = 'inline-flex items-center px-4 py-2 border border-transparent font-bold text-sm text-white rounded-md focus:outline-none focus:ring disabled:opacity-25 transition ease-in-out duration-150 ';

	// Switch button styling based on supplied format
	switch($format){
		case 'danger':
			$class .= 'bg-red-500  hover:bg-red-600 ring-red-200 focus:border-red-600';
			break;
		case 'frontend':
			$class .= 'bg-slate-500  hover:bg-slate-600 ring-slate-200 focus:border-slate-600';
			break;
		case 'primary':
		default:
			$class .= 'bg-indigo-500  hover:bg-indigo-600 ring-indigo-200 focus:border-indigo-600';     
			break;
    }
@endphp
<a {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</a>
