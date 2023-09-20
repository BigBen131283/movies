const btn = document.querySelector('.btn-unsubscribe');
const modal = document.querySelector('.unsubcribe-modal');

let toggle = false;
modal.style.display = "none";

btn.addEventListener('click', () => {
    
    toggle = !toggle;

    if(toggle){
        modal.style.display = "block";
        setTimeout(() => {
            modal.style.opacity = 1;
        }, 10)
    }else if (toggle === false){
        modal.style.opacity = 0;
        setTimeout(() => {
            modal.style.display = "none";
        }, 200)
    }
})