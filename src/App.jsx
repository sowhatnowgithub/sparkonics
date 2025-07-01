import {useEffect} from "react";
import Lenis from "lenis";

import {Navbar} from "./components/organisms/index.jsx";
import {Route, Routes} from "react-router";
import {About, EventsLanding, EventsModify, Landing,} from "./components/pages/index.jsx";


function App() {
    useEffect(() => {
        const lenis = new Lenis({
            duration: 1.2,
            easing: (t) => 1 - Math.pow(1 - t, 5),
            smooth: true,
            wheelMultiplier: 0.35,
        });
        
        
        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        
        requestAnimationFrame(raf);
        
        
        return () => {
            lenis.destroy();
        };
    }, []);
    
    return (
        <>
            <Navbar/>
            
            
            <div className="main">
                <Routes>
                    <Route index element={<Landing/>}/>
                    <Route path={"about"} element={<About/>}/>
                    
                    <Route path={"events"}>
                        <Route index element={<EventsLanding/>}/>
                    </Route>
                    
                    <Route path={"admin"}>
                        <Route path={"events"} element={<EventsModify/>}/>
                    </Route>
                </Routes>
            </div>
        </>
    );
}

export default App;
