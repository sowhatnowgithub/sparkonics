import "./styles.scss"
import {Link, NavLink} from "react-router";
import {useState} from "react";
import clsx from "clsx";
import {FlexBox} from "../../atoms/index.jsx";

const Navbar = () => {
    const [showSidenav, setShowSidenav] = useState(false)
    
    const onClickSidenav = (e) => {
        if (e.target == e.currentTarget) setShowSidenav(false);
        if (e.target.href != null) setShowSidenav(false)
    }
    
    return (
        <nav>
            <Link to={"/"} className={"icon"}>
                Sparkonics
            </Link>
            <FlexBox className={"options-desktop"}>
                <NavLink to={"/about/"} className={"option"}>About us</NavLink>
                <NavLink to={"/events/"} className={"option"}>Events</NavLink>
                <NavLink to={"/projects/"} className={"option"}>Projects</NavLink>
                <NavLink to={"/team/"} className={"option"}>The Team</NavLink>
                <NavLink to={"/connect/"} className={"option"}>Join us</NavLink>
            </FlexBox>
            
            
            <div className={clsx('hamburger', showSidenav && 'hamburger-toggled')} data-menu="1"
                 onClick={() => setShowSidenav(!showSidenav)}>
                <div className="icon-left"></div>
                <div className="icon-right"></div>
            </div>
            
            <div className={clsx('options-mobile-wrapper', showSidenav && 'options-mobile-shown')}
                 onClick={onClickSidenav}>
                <div className="options-mobile">
                    <Link to={"/"} className={"icon"}>
                        Sparkonics
                    </Link>
                    
                    <FlexBox column className={"options-"}>
                        <NavLink to={"/about/"} className={"option"}>About us</NavLink>
                        <NavLink to={"/events/"} className={"option"}>Events</NavLink>
                        <NavLink to={"/projects/"} className={"option"}>Projects</NavLink>
                        <NavLink to={"/team/"} className={"option"}>The Team</NavLink>
                        <NavLink to={"/connect/"} className={"option"}>Join us</NavLink>
                    </FlexBox>
                </div>
            </div>
        </nav>
    )
}


export default Navbar;