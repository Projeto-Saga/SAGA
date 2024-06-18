let count = 1;
document.getElementById("radio1").checked = true;

setInterval( function()
{
    nextImage();
}, 5000);

function nextImage()
{
    count++;
    
    count > 3 ? count = 1 : null;

    document.getElementById("radio"+count).checked = true;
}