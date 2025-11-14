<div class="mb-4">
    <label for="type" class=" text-white text-sm font-semibold">{{ $label }}</label>
    @if ($errors->has("$error"))
        <div class="text-red-500">{{ $errors->first("$error") }}</div>
    @endif
    <input type="{{ $type }}" id="type" name="{{ $name }}" value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        class="border-b-2 border-gray-300 w-full p-2 focus:outline-none focus:border-sky-500">
</div>
