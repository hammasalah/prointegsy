/**
 * Fonctions de partage sur les réseaux sociaux
 */

// Partage sur Facebook
function shareOnFacebook(url, title, description) {
    try {
        // Facebook ne prend en charge que l'URL dans le lien de partage standard
        // Pour inclure le titre et la description, nous utilisons les métadonnées Open Graph
        console.log('Partage Facebook:', url, title, description);
        
        // Vérifier que l'URL est valide
        if (!url || url.trim() === '') {
            throw new Error('URL invalide pour le partage Facebook');
        }
        
        var shareUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url);
        console.log('URL de partage Facebook:', shareUrl);
        
        // Ouvrir la fenêtre de partage Facebook
        var shareWindow = window.open(shareUrl, '_blank', 'width=600,height=400');
        
        if (!shareWindow) {
            throw new Error('La fenêtre de partage a été bloquée par le navigateur');
        }
    } catch (error) {
        debugShare('Facebook', error);
    }
}

// Partage sur Twitter
function shareOnTwitter(url, title) {
    try {
        console.log('Partage Twitter:', url, title);
        
        // Vérifier que l'URL est valide
        if (!url || url.trim() === '') {
            throw new Error('URL invalide pour le partage Twitter');
        }
        
        var shareUrl = 'https://twitter.com/intent/tweet?url=' + encodeURIComponent(url) + '&text=' + encodeURIComponent(title);
        console.log('URL de partage Twitter:', shareUrl);
        
        // Ouvrir la fenêtre de partage Twitter
        var shareWindow = window.open(shareUrl, '_blank', 'width=600,height=400');
        
        if (!shareWindow) {
            throw new Error('La fenêtre de partage a été bloquée par le navigateur');
        }
    } catch (error) {
        debugShare('Twitter', error);
    }
}

// Partage sur LinkedIn
function shareOnLinkedIn(url, title, description) {
    try {
        console.log('Partage LinkedIn:', url, title, description);
        
        // Vérifier que l'URL est valide
        if (!url || url.trim() === '') {
            throw new Error('URL invalide pour le partage LinkedIn');
        }
        
        // Construire l'URL de partage LinkedIn avec tous les paramètres
        var shareUrl = 'https://www.linkedin.com/shareArticle?mini=true&url=' + encodeURIComponent(url) + '&title=' + encodeURIComponent(title) + '&summary=' + encodeURIComponent(description);
        console.log('URL de partage LinkedIn:', shareUrl);
        
        // Ouvrir la fenêtre de partage LinkedIn
        var shareWindow = window.open(shareUrl, '_blank', 'width=600,height=600');
        
        if (!shareWindow) {
            throw new Error('La fenêtre de partage a été bloquée par le navigateur');
        }
    } catch (error) {
        debugShare('LinkedIn', error);
    }
}

// Partage sur WhatsApp
function shareOnWhatsApp(url, title) {
    try {
        console.log('Partage WhatsApp:', url, title);
        
        // Vérifier que l'URL est valide
        if (!url || url.trim() === '') {
            throw new Error('URL invalide pour le partage WhatsApp');
        }
        
        var shareUrl = 'https://api.whatsapp.com/send?text=' + encodeURIComponent(title + ' ' + url);
        console.log('URL de partage WhatsApp:', shareUrl);
        
        // Ouvrir la fenêtre de partage WhatsApp
        var shareWindow = window.open(shareUrl, '_blank', 'width=600,height=400');
        
        if (!shareWindow) {
            throw new Error('La fenêtre de partage a été bloquée par le navigateur');
        }
    } catch (error) {
        debugShare('WhatsApp', error);
    }
}

// Afficher/masquer le menu de partage
function toggleShareOptions(id) {
    console.log('Toggle share options for:', id);
    var element = document.getElementById(id);
    if (element) {
        element.classList.toggle('show');
    } else {
        console.error('Element not found:', id);
    }
}

// Fonction de débogage pour les erreurs de partage
function debugShare(network, error) {
    console.error('Erreur de partage sur ' + network + ':', error);
    alert('Erreur lors du partage sur ' + network + '. Vérifiez la console pour plus de détails.');
}

// Initialiser les gestionnaires d'événements une fois que le DOM est chargé
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM chargé, initialisation des gestionnaires d\'événements de partage');
    
    // Fonction pour initialiser tous les gestionnaires d'événements
    function initShareEvents() {
        console.log('Initialisation des gestionnaires d\'événements de partage');
        
        // Ajouter des écouteurs d'événements pour tous les boutons de partage
        var shareButtons = document.querySelectorAll('.btn-icon.share-toggle');
        console.log('Boutons de partage trouvés:', shareButtons.length);
        
        shareButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var id = 'share-options-' + this.getAttribute('data-id');
                console.log('Clic sur bouton de partage, id:', id);
                toggleShareOptions(id);
                
                // Initialiser les boutons de partage dans ce menu spécifique
                initShareButtonsInMenu(id);
            });
        });
        
        // Fermer les menus de partage si l'utilisateur clique en dehors
        document.addEventListener('click', function(event) {
            if (!event.target.matches('.btn-icon.share-toggle') && !event.target.closest('.share-options')) {
                var dropdowns = document.getElementsByClassName("share-options");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        });
    }
    
    // Fonction pour initialiser les boutons de partage dans un menu spécifique
    function initShareButtonsInMenu(menuId) {
        var menu = document.getElementById(menuId);
        if (!menu) {
            console.error('Menu de partage non trouvé:', menuId);
            return;
        }
        
        console.log('Initialisation des boutons dans le menu:', menuId);
        
        // Débogage: vérifier le contenu HTML du menu
        console.log('Contenu HTML du menu:', menu.innerHTML);
        console.log('Contenu HTML brut du menu:', menu.outerHTML);
        
        // Essayer de récupérer les attributs directement depuis le HTML
        var htmlContent = menu.innerHTML;
        console.log('Le menu contient-il des attributs data-url?', htmlContent.includes('data-url'));
        console.log('Le menu contient-il des attributs data-title?', htmlContent.includes('data-title'));
        console.log('Le menu contient-il des attributs data-description?', htmlContent.includes('data-description'));
        
        // Débogage: vérifier tous les boutons de partage dans le menu
        var allButtons = menu.querySelectorAll('.share-btn');
        console.log('Nombre de boutons trouvés:', allButtons.length);
        allButtons.forEach(function(btn, index) {
            console.log('Bouton', index, ':', btn.className);
            console.log('- data-url:', btn.getAttribute('data-url'));
            console.log('- data-title:', btn.getAttribute('data-title'));
            console.log('- data-description:', btn.getAttribute('data-description'));
        });
        
        // Facebook
        var facebookBtn = menu.querySelector('.share-btn.facebook');
        if (facebookBtn) {
            facebookBtn.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                var url = this.getAttribute('data-url');
                var title = this.getAttribute('data-title');
                var description = this.getAttribute('data-description');
                console.log('Clic sur Facebook dans', menuId, '- Données:', url, title, description);
                shareOnFacebook(url, title, description);
            };
        }
        
        // LinkedIn
        var linkedinBtn = menu.querySelector('.share-btn.linkedin');
        if (linkedinBtn) {
            linkedinBtn.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                var url = this.getAttribute('data-url');
                var title = this.getAttribute('data-title');
                var description = this.getAttribute('data-description');
                console.log('Clic sur LinkedIn dans', menuId, '- Données:', url, title, description);
                shareOnLinkedIn(url, title, description);
            };
        }
        
        // Twitter
        var twitterBtn = menu.querySelector('.share-btn.twitter');
        if (twitterBtn) {
            twitterBtn.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                var url = this.getAttribute('data-url');
                var title = this.getAttribute('data-title');
                console.log('Clic sur Twitter dans', menuId, '- Données:', url, title);
                shareOnTwitter(url, title);
            };
        }
        
        // WhatsApp
        var whatsappBtn = menu.querySelector('.share-btn.whatsapp');
        if (whatsappBtn) {
            whatsappBtn.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                var url = this.getAttribute('data-url');
                var title = this.getAttribute('data-title');
                console.log('Clic sur WhatsApp dans', menuId, '- Données:', url, title);
                shareOnWhatsApp(url, title);
            };
        }
    }
    
    // Initialiser tous les gestionnaires d'événements
    initShareEvents();
});