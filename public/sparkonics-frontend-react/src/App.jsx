import { useEffect } from "react";
import Lenis from "lenis";
import VanillaPageWrapper from "./VanillaPageWrapper";

import { Navbar } from "./components/organisms/index.jsx";
import { Route, Routes } from "react-router";
import {
  EventsLanding,
  EventsModify,
  Landing,
} from "./components/pages/index.jsx";

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

  const baseurl = window.location.origin;
  //const baseurl = "http://localhost";
  return (
    <>
      <Navbar />
      <div className="main">
        <Routes>
          <Route path="events">
            <Route index element={<EventsLanding />} />
          </Route>
          <Route
            path="/gallery"
            element={<VanillaPageWrapper src={`${baseurl}/gallery`} />}
          />
          <Route
            path="/profs"
            element={<VanillaPageWrapper src={`${baseurl}/profs`} />}
          />
          <Route
            path="/teams"
            element={<VanillaPageWrapper src={`${baseurl}/teams`} />}
          />
          <Route
            path="/opp"
            element={<VanillaPageWrapper src={`${baseurl}/opp`} />}
          />
        </Routes>
      </div>
    </>
  );
}

export default App;
