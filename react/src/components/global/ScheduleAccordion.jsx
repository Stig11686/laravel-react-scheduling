import { useState } from "react";

function ScheduleAccordion({ course, cohort, children }) {
  const [isOpen, setIsOpen] = useState(false);

  function handleOpen() {
    setIsOpen((prev) => !prev);
  }

  return (
    <>
      <div className="my-6 border border-1 border-gray-300 focus-gray-900 py-6 px-6 rounded">
        <header onClick={handleOpen}>
          <h2>
            <span>
              {course} - {cohort}
            </span>
          </h2>
        </header>
        <div className={!isOpen ? "hidden" : "block"}>{children}</div>
      </div>
    </>
  );
}

export default ScheduleAccordion;
