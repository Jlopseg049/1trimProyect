window.addEventListener("load",()=>{
    var date = document.getElementById("date");

    date.addEventListener("focus", ()=>{
        if(date.value == ""){
            date.type="date";
        }
    });

    date.addEventListener("focusout", ()=>{
        if(date.value == ""){
            date.type="text";
        }
    });
});