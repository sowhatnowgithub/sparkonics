import React from "react";
import "./container.css";
const VanillaPageWrapper = ({ src }) => {
  return (
    <>
      <div className="iframe-container">
        <iframe src={src} title="Vanilla Page" />
      </div>
    </>
  );
};

export default VanillaPageWrapper;
