@props(['id', 'title' => 'Confirmation', 'message' => 'Voulez-vous vraiment continuer ?', 'route', 'method' => 'POST'])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $message }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ $route }}" method="POST">
                    @csrf
                    @method($method)
                    <button class="btn btn-danger">Confirmer</button>
                </form>
            </div>
        </div>
    </div>
</div>
