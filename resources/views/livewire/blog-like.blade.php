
    <div>
        <button wire:click="like" class="{{ $liked ? 'text-red-500' : 'text-gray-500' }}">
            {{ $liked ? 'Unlike' : 'Like' }} ({{ $likesCount }}) <!-- Cambié a $likesCount -->
        </button>
    </div>
    
