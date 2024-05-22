
const startProgressBar = ()=>{
    document.getElementById("loading").style.display = "block";
}

const stopProgressBar = ()=>{
    document.getElementById("loading").style.display = "none";
}

export {
    startProgressBar,
    stopProgressBar
}