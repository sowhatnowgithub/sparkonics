import React from "react";

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
