<div class="p-4 bg-white rounded shadow">
    <h3 class="font-bold text-lg mb-2">Profile Summary</h3>

    <p><strong>Sections:</strong>
        @forelse($sections as $section)
        {{ $section->name }},
        @empty
        None
        @endforelse
    </p>

    <p><strong>Certifications:</strong>
        @forelse($certifications as $cert)
        {{ $cert->name }},
        @empty
        None
        @endforelse
    </p>
</div>