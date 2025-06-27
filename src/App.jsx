import {Navbar} from "./components/organisms/index.jsx";
import {Route, Routes} from "react-router";
import {About, EventsLanding, EventsModify, Landing} from "./components/pages/index.jsx";

function App() {
    
    return (
        <>
            <Navbar/>
            
            <div className="main">
                <Routes>
                    <Route index element={<Landing/>}/>
                    <Route path={"about"} element={<About/>}/>
                    
                    <Route path={"events"}>
                        <Route index element={<EventsLanding/>}/>
                        <Route path={"modify"} element={<EventsModify/>}/>
                    </Route>
                </Routes>
            </div>
        </>
    )
}

export default App
