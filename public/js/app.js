function addBorderElement(id)
{
    const el = document.getElementById(id);
    el.style.borderBottom = "5px solid #dcc865";
    el.querySelector('.header__link').style.marginTop = "5px";
}

function removeBorderElement(id)
{
    const el = document.getElementById(id);
    el.style.borderBottom = "none";
    el.querySelector('.header__link').style.marginTop = "0";
}

function changeBurger()
{
    document.querySelector('.header__burger').classList.toggle('active');
    document.querySelector('.header__menu').classList.toggle('active');
    document.querySelector('body').classList.toggle('active');
}

