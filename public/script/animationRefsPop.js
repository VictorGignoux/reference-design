document.addEventListener('DOMContentLoaded', function ()
{
	refs = document.querySelectorAll('.lien-reference');

	refs.forEach((ref, index) => {
		setTimeout(() => {
			ref.style.transition = "0.5s";
			ref.style.transform = 'scale(1)';
		}, 15 * index);
	});
});