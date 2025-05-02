function UpdateFavorite(id)
{
    const idImg = "btnfavimg_" + id;
    const idInput = "isfavored_" + id;
    const idChangeTracker = "isChanged_" + id;

    const element = document.getElementById(idImg);

    const input = document.getElementById(idInput);

    const ChangeTracker = document.getElementById(idChangeTracker);

    if (element.getAttribute("src") == '/UNDERPLAY/views/ressources/images/icons/favored.jpg')
    {
        element.setAttribute("src",'/UNDERPLAY/views/ressources/images/icons/unfavored.jpg');
        input.setAttribute("value", "unfavored");
    }else
    {
        element.setAttribute("src",'/UNDERPLAY/views/ressources/images/icons/favored.jpg');
        input.setAttribute("value", "favored");
    }

    if(ChangeTracker.getAttribute("value") == "Unchanged")
    {
        ChangeTracker.setAttribute("value", "Changed");
    }
}

function UpdateChapter(modification, id)
{
    const idText = "displaychapter_" + id;
    const idInput = "newChapter_" + id;
    const idChangeTracker = "isChanged_" + id;

    const element = document.getElementById(idText);
    var Chapter = parseInt(element.textContent);

    const input = document.getElementById(idInput);

    const ChangeTracker = document.getElementById(idChangeTracker);

    if (modification == "-")
    {
        if (Chapter > 1)
        {
            Chapter -= 1;
        }
    }else
    {
        Chapter += 1;
    }
    element.innerHTML = Chapter;
    input.setAttribute("value", Chapter.toString());

    if(ChangeTracker.getAttribute("value") == "Unchanged")
    {
        ChangeTracker.setAttribute("value", "Changed");
    }
}