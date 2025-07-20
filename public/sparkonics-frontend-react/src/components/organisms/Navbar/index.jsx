import "./styles.scss";
import { Link, NavLink } from "react-router";
import { useState } from "react";
import clsx from "clsx";
import { FlexBox } from "../../atoms/index.jsx";

const Navbar = () => {
  const [showSidenav, setShowSidenav] = useState(false);

  const onClickSidenav = (e) => {
    if (e.target === e.currentTarget) setShowSidenav(false);
    if (e.target.href != null) setShowSidenav(false);
  };

  return (
    <nav>
      <Link to={"/"} className={"icon"}>
        Sparkonics
      </Link>
      <FlexBox className={"options-desktop"}>
        <NavLink to={"/events/"} className={"option"}>
          Events
        </NavLink>
        <a href="/gallery" className="option">
          Projects/Gallery
        </a>
        <a href="/profs" className="option">
          Professors
        </a>
        <NavLink
          to="/thrds"
          target="_blank"
          className="option"
          rel="noopener noreferrer"
        >
          Thrds
        </NavLink>
        <a href="/teams/" className="option">
          Team
        </a>
        <a href="/oa" className="option">
          OA
        </a>
        <NavLink to="/dev" className="option">
          DevX
        </NavLink>
        <NavLink
          to="/admin/"
          target="_blank"
          className="option"
          rel="noopener noreferrer"
        >
          Admin
        </NavLink>
      </FlexBox>

      <div
        className={clsx("hamburger", showSidenav && "hamburger-toggled")}
        data-menu="1"
        onClick={() => setShowSidenav(!showSidenav)}
      >
        <div className="icon-left"></div>
        <div className="icon-right"></div>
      </div>

      <div
        className={clsx(
          "options-mobile-wrapper",
          showSidenav && "options-mobile-shown",
        )}
        onClick={onClickSidenav}
      >
        <FlexBox fullWidth column align className="options-mobile">
          <NavLink to={"/events/"} className={"option"}>
            Events
          </NavLink>
          <a href="/gallery" className="option">
            Projects/Gallery
          </a>
          <a href="/profs" className="option">
            Professors
          </a>
          <NavLink
            to="/thrds"
            target="_blank"
            className="option"
            rel="noopener noreferrer"
          >
            Thrds
          </NavLink>
          <a href="/teams/" className="option">
            Team
          </a>
          <a href="/oa" className="option">
            OA
          </a>
          <NavLink to="/dev" className="option">
            DevX
          </NavLink>
          <NavLink
            to="/admin/"
            target="_blank"
            className="option"
            rel="noopener noreferrer"
          >
            Admin
          </NavLink>
        </FlexBox>
      </div>
    </nav>
  );
};

export default Navbar;
