import { useEffect, useState } from "react";
import Loading from "./Loadin.jsx";
import FuturisticNavbar from "../../organisms/Navbar/index.jsx";
const Landing = () => {
  const [loadingDone, setLoadingDone] = useState(false);

  useEffect(() => {
    const timer = setTimeout(() => setLoadingDone(true), 1300);
    return () => clearTimeout(timer);
  }, []);

  if (!loadingDone) return <Loading />;

  return (
    <>
      <FuturisticNavbar />
      <main className="min-h-screen bg-black text-white">
        <div className="p-10">
          <h1 className="text-4xl font-bold">Landing Page</h1>
          <p className="mt-4">Welcome to Sparkonics!</p>
        </div>
      </main>
    </>
  );
};

export default Landing;
