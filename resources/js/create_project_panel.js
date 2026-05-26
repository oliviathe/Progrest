document.addEventListener('DOMContentLoaded', () => {

    const panel = document.getElementById('panel');
    const overlay = document.getElementById('overlay');
    
    window.openPanel = function () {
        panel.classList.remove('translate-x-full');
        overlay.classList.remove('hidden');
    }
    
    window.closePanel = function () {
        panel.classList.add('translate-x-full');
        overlay.classList.add('hidden');
    }
    
    overlay.addEventListener('click', closePanel); 

    window.selectTheme = function (theme, element) {

        document.getElementById('selectedTheme').value = theme; 

        document.querySelectorAll('.theme-option').forEach(option => {
            option.classList.remove('ring-4', 'ring-offset-2');

            const themeIcon = option.querySelector('.theme-check-icon'); 

            if(themeIcon){
                themeIcon.classList.add('hidden'); 
            }

        });

        element.classList.add('ring-4', 'ring-offset-2');
        const themeIcon = element.querySelector('.theme-check-icon'); 

        if(themeIcon){
            themeIcon.classList.remove('hidden'); 
        }
    }

    window.selectIcon = function(icon, element){

        document.getElementById('selectedIcon').value = icon; 

        document.querySelectorAll('.icon-option').forEach(option => {
            option.classList.remove('bg-quartiary/80'); 
            option.classList.add('bg-background'); 
            option.classList.add('hover:bg-secondary'); 

            const iconIcon = option.querySelector('.icon-icon'); 

            if(iconIcon){
                iconIcon.classList.remove('text-text-contrast'); 
                iconIcon.classList.add('text-text-secondary'); 
            }
        })

        element.classList.remove('bg-background'); 
        element.classList.add('bg-quartiary/80'); 
        element.classList.remove('hover:bg-secondary'); 

        const iconIcon = element.querySelector('.icon-icon'); 

        if(iconIcon){
            iconIcon.classList.remove('text-text-secondary'); 
            iconIcon.classList.add('text-text-contrast'); 
        }
    }
});