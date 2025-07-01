import {useEffect} from "react";
import "./styles.scss"

const AnimationManager = () => {
    useEffect(() => {
        const fadeObserver = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("animation-fade-slide-in-shown");
                } else {
                    entry.target.classList.remove("animation-fade-slide-in-shown");
                }
            });
        }, {threshold: .5});
        
        
        const observeFadeElements = () => {
            const elements = document.querySelectorAll(".animation-fade-slide-in");
            elements.forEach(el => fadeObserver.observe(el));
        };
        
        requestAnimationFrame(() => {
            observeFadeElements();
        });
        
        
        const mutationObserver = new MutationObserver(mutations => {
            for (const mutation of mutations) {
                if (mutation.type === "childList") {
                    observeFadeElements();
                }
            }
        });
        
        mutationObserver.observe(document.body, {
            childList: true,
            subtree: true,
        });
        
        return () => {
            fadeObserver.disconnect();
            mutationObserver.disconnect();
        };
    }, []);
    
    return null;
};

export default AnimationManager;
