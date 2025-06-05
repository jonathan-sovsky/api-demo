<?php
$pageTitle = "API Demo";
$bodyClass = "bg-light";
include '../partials/header.php';
?>

<div class="container py-5">
    <h1 class="text-center mb-4">Rick & Morty API Demo</h1>
    <p class="text-center text-muted mb-5">Enter a character ID and fetch data from the public Rick and Morty API. This demonstrates API integration, JSON handling, and dynamic DOM updates.</p>

    <!-- Input -->
    <div class="row mb-4">
        <div class="col-md-6 offset-md-3">
            <input type="number" id="characterId" class="form-control" placeholder="Enter Character ID (1–826)">
        </div>
    </div>

    <!-- Button -->
    <div class="text-center mb-4">
        <button class="btn btn-primary btn-lg" onclick="fetchCharacter()">Fetch Character</button>
    </div>

    <!-- Output -->
    <div id="characterInfo" class="text-center mb-4"></div>

    <!-- Raw JSON -->
    <h5 class="text-muted mt-5">Raw JSON Response:</h5>
    <pre id="rawJson" class="bg-light p-3 rounded shadow-sm" style="max-height: 400px; overflow: auto;"></pre>
</div>

<script>
function fetchCharacter() {
    const id = $('#characterId').val().trim();
    if (!id || isNaN(id)) {
        $('#characterInfo').html('<p class="text-danger">Please enter a valid character ID.</p>');
        $('#rawJson').text('');
        return;
    }

    const url = `https://rickandmortyapi.com/api/character/${id}`;
    $('#characterInfo').html('<p>Loading...</p>');
    $('#rawJson').text('');

    fetch(url)
        .then(response => {
            if (!response.ok) throw new Error('Character not found');
            return response.json();
        })
        .then(data => {
            $('#characterInfo').html(`
                <h3>${data.name}</h3>
                <img src="${data.image}" class="img-fluid rounded mb-3" style="max-width: 200px;" />
                <p><strong>Status:</strong> ${data.status}</p>
                <p><strong>Species:</strong> ${data.species}</p>
                <p><strong>Origin:</strong> ${data.origin.name}</p>
            `);
            $('#rawJson').text(JSON.stringify(data, null, 2));
        })
        .catch(error => {
            $('#characterInfo').html(`<p class="text-danger">${error.message}</p>`);
        });
}
</script>

<?php include '../partials/footer.php'; ?>
