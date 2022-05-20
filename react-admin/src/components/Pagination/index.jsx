import React, { useState } from "react";
import PropTypes from "prop-types";
import "./pagi.css";

Pagination.propTypes = {
  pagination: PropTypes.object.isRequired,
  onPageChange: PropTypes.func,
};
Pagination.defaultProps = {
  onPageChange: null,
};

function Pagination(props) {
  const { pagination, onPageChange } = props;
  const { _page, _limit, _totalRows } = pagination;
  const totalPages = Math.ceil(_totalRows / _limit);
  const [color, setColor] = useState(true);
  // 51/10 = 5.1 => 6

  function handlePageChange(newPage) {
    setColor(!color);
    if (onPageChange) {
      onPageChange(newPage);
    }
  }
  return (
    <div className="Pagi-page">
      <button
        disabled={_page <= 1}
        onClick={() => handlePageChange(_page - 1)}
        className={color ? "active-color" : "non-active-color"}
      >
        Prev
      </button>

      <button
        disabled={_page >= totalPages}
        onClick={() => handlePageChange(_page + 1)}
        className={color ? "non-active-color" : "active-color"}
      >
        Next
      </button>
    </div>
  );
}

export default Pagination;
