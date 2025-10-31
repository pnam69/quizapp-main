<div>
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th wire:click="toggleSort()" class="cursor-pointer">
                    Question
                    @if($sortDirection === 'asc') ↑ @else ↓ @endif
                </th>
                <th>Answers</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions as $question)
            <tr>
                <td>{{ $question->question }}</td>
                <td>
                    <ul>
                        @foreach($question->answers as $answer)
                        <li>{{ $answer->answer_text }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $questions->links() }}
    </div>
</div>