let colors = {
	OBJET:"#f6b6bb",
	MODE:"#e94f28",
	ARCHI:"#cdb85c",
	GRAPHISME:"#e0858e",
	ART:"#bad8f3"
};

document.addEventListener('DOMContentLoaded', function (){
	const categorie = document.getElementById("body").getAttribute('data-categorie');
	document.documentElement.style.setProperty('--change', colors[categorie]);

	/* affichage des boutons de modification, ajout et suppression */
	let isCrudDisplayed = false;
	const crudBoutons = document.querySelectorAll('.crud-bouton');
	const boutonCRUD = document.getElementById('header-bouton-image');
	boutonCRUD.addEventListener('click', function(){
		if(isCrudDisplayed){
			isCrudDisplayed = false;
			crudBoutons.forEach(child => {
				child.style.pointerEvents = 'none';
				child.style.opacity = '0';
				child.style.transform = 'translateY(0vh)';
			})
		}
		else{
			isCrudDisplayed = true;
			crudBoutons.forEach((child, index) => {
				let top = 3 + index * 5;
				child.style.pointerEvents = 'auto';
				child.style.opacity = "100%";
				child.style.transform = `translateY(${top}vh)`;
			})
		}
	});
});