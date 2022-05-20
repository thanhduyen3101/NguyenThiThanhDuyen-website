import React, { useState, useEffect } from "react";
import axios from "axios";
import ProductItem from "../components/productItem.jsx";
import { Dropdown } from "react-bootstrap";
import AddProduct from "./Login/AddProduct.jsx";
import { apiUrl } from "../context/Constants";

import Pagination from "../components/Pagination/index.jsx";

const Products = (props) => {
  const [addmodalOpen, setAddmodalOpen] = useState(false);
  const [pagination, setPagination] = useState({
    _page: 1,
    _limit: 100,
    _totalRows: 200,
  });
  const [products, setProducts] = useState();
  const [value, setValue] = useState(false);
  const [pagi, setPagi] = useState(1);
  const [id, setId] = useState(props.match.params.id);

  const limit = 100;

  function handlePageChange(newPage) {
    setPagi(newPage);
    setPagination({
      ...pagination,
      ["_page"]: newPage,
    });
    console.log("New Page:", newPage);
  }

  async function fetchData() {
    axios.defaults.headers.common[
      "Authorization"
    ] = `Bearer ${localStorage["token"]}`;
    const response = await axios.get(`${apiUrl}/product/list/`+ props.match.params.id);
    setProducts(response.data.data);
    setPagination({
      ...pagination,
      ["_totalRows"]: response.data.data ? response.data.data.length : 0,
    });
    setValue(false);
  }

  useEffect(() => {
    fetchData();
  }, [value]);
  return (
    <div>
      <h2 className="page-header">Bài giảng</h2>
      <div className="row">
        <div className="col-12">
          <div className="card">
            <div className="card__header">
              <div className="add-new-cate">
                <button onClick={() => setAddmodalOpen(!addmodalOpen)}>
                  Thêm mới bài giảng
                </button>
                {addmodalOpen ? (
                  <AddProduct
                    setOpenModal={setAddmodalOpen}
                    setValue={setValue}
                    courseId={id}
                  />
                ) : null}
              </div>
            </div>
            {!products ? (
              <div className="w-100 text-center">
                <div className="spinner-border text-dark" role="status"></div>
              </div>
            ) : null}
            <div className="product-panel">
              {products
                ?.slice(limit * (pagi - 1), limit + limit * (pagi - 1))
                .map((item, index) => {
                  return (
                    <ProductItem
                      key={index}
                      id={item.id}
                      img={item.image}
                      name={item.title}
                      content={item.content}
                      course_name={item.course_name}
                      setValue={setValue}
                    />
                  );
                })}
            </div>
          </div>
        </div>
      </div>
      {/* <Pagination pagination={pagination} onPageChange={handlePageChange} /> */}
    </div>
  );
};

export default Products;
