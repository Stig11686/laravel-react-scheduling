function PaginationComponent({ currentPage, lastPage, onPageChange }) {
  return (
    <div className="mt-6 max-w-3xl">
      {/* Pagination controls */}
      <div>
        <button
          onClick={() => onPageChange(currentPage - 1)}
          disabled={currentPage === 1}
          className="bg-blue-200 px-4 py-2 rounded"
        >
          Previous
        </button>
        <span className="px-2 py-2">
          {currentPage} of {lastPage}
        </span>
        <button
          onClick={() => onPageChange(currentPage + 1)}
          disabled={currentPage === lastPage}
          className="bg-blue-200 px-4 py-2 rounded"
        >
          Next
        </button>
      </div>
    </div>
  );
}

export default PaginationComponent;
