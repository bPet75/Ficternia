let draggables = null;
function swapButtons(){
    var reorderButton = document.getElementById('reorderButton');
    var saveOrderButton = document.getElementById('saveOrder');
    if(reorderButton.disabled == true){
        reorderButton.classList.remove('hide');
        saveOrderButton.classList.add('hide');
    }else{
        saveOrderButton.classList.remove('hide');
        reorderButton.classList.add('hide');
    }
    saveOrderButton.disabled = !saveOrderButton.disabled;
    reorderButton.disabled = !reorderButton.disabled;
}
function allowMoving(){
    swapButtons();
    var buttonContainer = document.getElementsByClassName("controlButtonsInnerContainer")[0];
    var buttons = buttonContainer.getElementsByClassName('normControlButton');
    for(let i = 0; i< buttons.length; i++){
        let button = buttons[i];
        if(button.disabled == true){
            button.disabled = false;
        }
        else{
            button.disabled = true;
        }
    }
        
    
    var chapterCheckboxes = document.querySelectorAll(".checkbox");
    for(let i = 0; i<chapterCheckboxes.length; i++){
        chapterCheckboxes[i].checked =true;
    }


    var chapterElements = document.getElementsByClassName("chapterElementContainer");
    for(let i = 0; i<chapterElements.length; i++){
        let chapterElement = chapterElements[i];
        if(chapterElement.getAttribute("draggable") == "false"){
            chapterElement.setAttribute("draggable", true);
            chapterElement.classList.remove("nonDraggable");
            chapterElement.classList.add("draggable");
        }else{
            chapterElement.setAttribute("draggable", false);
            chapterElement.classList.remove("draggable");
            chapterElement.classList.add("nonDraggable");
        }
    }
    draggables = document.querySelectorAll('.draggable');
    const containers = document.getElementsByClassName('chapterListInner');
    draggables.forEach(draggable =>{
        draggable.addEventListener('dragstart', ()=>{
            draggable.classList.add('dragging');
        })

        draggable.addEventListener('dragend', ()=>{
            draggable.classList.remove('dragging');
        })
    })
    Object.values(containers).forEach(container => {
        container.addEventListener('dragover', e => {
          e.preventDefault()
          const afterElement = getDragAfterElement(container, e.clientY)
          const draggable = document.querySelector('.dragging')
          if (afterElement == null) {
            container.appendChild(draggable)
          } else {
            container.insertBefore(draggable, afterElement)
          }
        })
      })
}
function getDragAfterElement(container, y){
    const draggableElements = [...container.querySelectorAll('.draggable:not(.dragging)')];

    return draggableElements.reduce((closest, child)=>{
        const box = child.getBoundingClientRect();
        const offset = y -box.top - box.height/2;
        if(offset < 0 && offset>closest.offset){
            return {offset: offset, element: child};
        }else{
            return closest;
        }
    }, {offset: Number.NEGATIVE_INFINITY }).element;
}
