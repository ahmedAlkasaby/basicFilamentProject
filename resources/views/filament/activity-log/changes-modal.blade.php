<div class="w-full overflow-x-auto">
    <table class="table-auto w-full border-collapse border border-gray-200 rounded-lg text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 text-left font-semibold text-gray-700 border-b w-1/4">
                    {{ __('site.attribute') }}
                </th>
                <th class="px-4 py-2 text-left font-semibold text-red-600 border-b w-2/4">
                    {{ __('site.before') }}
                </th>
                <th class="px-4 py-2 text-left font-semibold text-green-600 border-b w-2/4">
                    {{ __('site.after') }}
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            @forelse ($changes as $attribute => $values)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-2 font-medium text-gray-900 min-w-[150px]">
                        {{ \Illuminate\Support\Str::headline($attribute) }}
                    </td>
                    <td class="px-4 py-2 text-sm text-red-500 break-words min-w-[200px]">
                        {{ $record->formatChangeValue($model, $attribute, $values['old'] ?? '-') }}
                    </td>
                    <td class="px-4 py-2 text-sm text-green-600 font-semibold break-words min-w-[200px]">
                        {{ $record->formatChangeValue($model, $attribute, $values['new'] ?? '-') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-4 py-6 text-center text-gray-500 italic">
                        {{ __('site.no_changes_found') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
