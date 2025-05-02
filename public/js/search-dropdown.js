/**
 * Script pour gérer la recherche en temps réel et l'autocomplétion
 */
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchDropdown = document.getElementById('searchDropdown');
    const searchForm = document.querySelector('.search-form');
    let searchTimeout;

    if (!searchInput || !searchDropdown) return;

    // Fonction pour effectuer la recherche
    function performSearch(query) {
        if (query.length < 2) {
            searchDropdown.innerHTML = '';
            searchDropdown.classList.remove('active');
            return;
        }

        // Afficher un indicateur de chargement
        searchDropdown.innerHTML = '<div class="search-loader"><i class="fas fa-spinner fa-spin"></i> Recherche en cours...</div>';
        searchDropdown.classList.add('active');

        // Utiliser une requête normale au lieu de l'API
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `/social/search-ajax?search=${encodeURIComponent(query)}`, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const data = JSON.parse(xhr.responseText);
                    displayResults(data, query);
                } catch (e) {
                    searchDropdown.innerHTML = '<div class="search-error">Erreur de format de réponse.</div>';
                    console.error('Erreur de parsing:', e);
                }
            } else {
                searchDropdown.innerHTML = '<div class="search-error">Une erreur est survenue lors de la recherche.</div>';
                console.error('Erreur de recherche:', xhr.statusText);
            }
        };
        xhr.onerror = function() {
            searchDropdown.innerHTML = '<div class="search-error">Une erreur est survenue lors de la recherche.</div>';
            console.error('Erreur de connexion');
        };
        xhr.send();
    }

    // Fonction pour afficher les résultats
    function displayResults(data, query) {
        // Vérifier si des résultats ont été trouvés
        const hasUsers = data.users && data.users.length > 0;
        const hasGroups = data.groups && data.groups.length > 0;

        if (!hasUsers && !hasGroups) {
            searchDropdown.innerHTML = `<div class="search-no-results">Aucun résultat pour "${query}"</div>`;
            return;
        }

        let html = '<div class="search-results-panel">';

        // Afficher les utilisateurs
        if (hasUsers) {
            html += '<div class="search-section"><h3>Utilisateurs</h3>';
            data.users.slice(0, 3).forEach(user => {
                html += `
                <div class="search-result-item">
                    <div class="result-avatar">
                        <img src="/uploads/images/default-avatar.png" alt="${user.username}">
                    </div>
                    <div class="result-info">
                        <div class="result-name">${user.username}</div>
                        <div class="result-bio">${user.email}</div>
                    </div>
                </div>`;
            });
            if (data.users.length > 3) {
                html += `<div class="search-more"><a href="/social/search?search=${encodeURIComponent(query)}">Voir plus d'utilisateurs</a></div>`;
            }
            html += '</div>';
        }

        // Afficher les groupes
        if (hasGroups) {
            html += '<div class="search-section"><h3>Groupes</h3>';
            data.groups.slice(0, 3).forEach(group => {
                html += `
                <div class="search-result-item">
                    <div class="result-avatar">
                        <img src="/uploads/images/default-group.png" alt="${group.name}">
                    </div>
                    <div class="result-info">
                        <div class="result-name">${group.name}</div>
                        <div class="result-bio">${group.description || 'Aucune description'}</div>
                    </div>
                </div>`;
            });
            if (data.groups.length > 3) {
                html += `<div class="search-more"><a href="/social/search?search=${encodeURIComponent(query)}">Voir plus de groupes</a></div>`;
            }
            html += '</div>';
        }

        // Ajouter un lien pour voir tous les résultats
        html += `<div class="search-view-all"><a href="/social/search?search=${encodeURIComponent(query)}">Voir tous les résultats</a></div>`;
        html += '</div>';

        searchDropdown.innerHTML = html;
    }

    // Événement de saisie dans le champ de recherche
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        // Effacer le timeout précédent pour éviter les requêtes multiples
        clearTimeout(searchTimeout);
        
        // Définir un délai avant d'effectuer la recherche (pour éviter trop de requêtes)
        searchTimeout = setTimeout(() => {
            performSearch(query);
        }, 300);
    });

    // Fermer le dropdown lorsqu'on clique ailleurs sur la page
    document.addEventListener('click', function(event) {
        if (!searchForm.contains(event.target)) {
            searchDropdown.classList.remove('active');
        }
    });

    // Empêcher la soumission du formulaire lorsqu'on appuie sur Entrée
    searchForm.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            window.location.href = `/social/search?search=${encodeURIComponent(searchInput.value.trim())}`;
        }
    });

    // Gérer le clic sur le bouton de recherche
    const searchButton = document.querySelector('.search-button');
    if (searchButton) {
        searchButton.addEventListener('click', function() {
            window.location.href = `/social/search?search=${encodeURIComponent(searchInput.value.trim())}`;
        });
    }
});