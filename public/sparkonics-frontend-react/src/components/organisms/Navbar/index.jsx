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
        <NavLink to="/gallery" className="option">
          Projects/Gallery
        </NavLink>
        <NavLink to="/profs" className="option">
          Professor
        </NavLink>
        {/* External link: keep <a> */}
        <a
          href="/thrds"
          target="_blank"
          className="option"
          rel="noopener noreferrer"
        >
          Thrds
        </a>
        <NavLink to="/teams/" className="option">
          Team
        </NavLink>
        <NavLink to="/oa" className="option">
          OA
        </NavLink>
        <NavLink to="/opp/" className="option">
          Opportunities
        </NavLink>
        <NavLink to="/dev" className="option">
          DevX
        </NavLink>
        {/* External admin link */}
        <a
          href="/admin/"
          target="_blank"
          className="option"
          rel="noopener noreferrer"
        >
          Admin
        </a>
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
          <NavLink to="/gallery" className="option">
            Projects/Gallery
          </NavLink>
          <NavLink to="/profs" className="option">
            Professor
          </NavLink>
          <a
            href="/thrds"
            target="_blank"
            className="option"
            rel="noopener noreferrer"
          >
            Thrds
          </a>
          <NavLink to="/teams/" className="option">
            Team
          </NavLink>
          <NavLink to="/oa" className="option">
            OA
          </NavLink>
          <NavLink to="/opp/" className="option">
            Opportunities
          </NavLink>
          <NavLink to="/dev" className="option">
            DevX
          </NavLink>
          <a
            href="/admin/"
            target="_blank"
            className="option"
            rel="noopener noreferrer"
          >
            Admin
          </a>
        </FlexBox>
      </div>
    </nav>
  );
};

export default Navbar;
