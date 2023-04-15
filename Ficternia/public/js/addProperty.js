function newProp(){
    var propertyName = document.getElementById("newPropertyName").value;
    var propertyContainer = document.getElementById("customPropertyContainer");
    var customPropertyList = Array.from(document.getElementsByClassName("customProperty"));
    var exist = false;
    for (let i = 0; i < customPropertyList.length; i++) {
        if(customPropertyList[i].name == "custProp_"+propertyName){
            exist = true;
        }
    }
    if(exist){
        alert("A létrehozni kívánt egyedi tulajdonság már létezik!")
    }else{
        propertyContainer.insertAdjacentHTML('beforeend',`
            <div class="my-2 d-flex flex-column w-25">
                <label for="properties_id" class="h3 mb-3"> `+propertyName+` </label>
                <textarea
                    class=" formInput border border-dark customProperty"
                    name="custProp_`+propertyName+`"
                    rows="4"
                    cols="150"
                    ></textarea>
                    
        </div>`);
    }
}