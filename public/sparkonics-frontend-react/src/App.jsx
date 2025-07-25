import { useEffect } from "react";
import Lenis from "lenis";
import VanillaPageWrapper from "./VanillaPageWrapper";

import { Navbar } from "./components/organisms/index.jsx";
import { Route, Routes } from "react-router";
import { Events, Landing } from "./components/pages/index.jsx";

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

  return (
    <>
      {/* Navbar Overlay */}
      <div id="navbar-overlay">
        <Navbar />
      </div>

      {/* Main Content Below */}
      <div className="main-content">
        <Routes>
          <Route path="/">
            <Route index element={<Landing />} />
          </Route>
          <Route path="/events">
            <Route index element={<Events />} />
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
