import React, { useState, useEffect } from "react";

import axios from "axios";

import Table from "../components/table/Table";

import AddcateModal from "../components/modal/AddcateModal";

import EditcateModal from "../components/modal/EditcateModal";

import Row from "../components/Row";

import { apiUrl } from "../context/Constants";

import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

const cateTableHead = ["ID", "Tên khóa học", "Học viên tối đa", "Học viên hiện tại", "Thao tác", "Mô tả"];

const renderHead = (item, index) => <th key={index}>{item}</th>;
const Category = () => {
  const [addmodalOpen, setaddmodalOpen] = useState(false);
  const [editmodalOpen, setEditmodalOpen] = useState(false);

  const [categories, setCategories] = useState();
  const [idCate, setIdCate] = useState("");
  const [value, setValue] = useState(false);
  // const [update, setUpdate] = useState(false);

  async function fetchData() {
    setCategories(null);
    const response = await axios.get(`${apiUrl}/admin/category/list`);
    setCategories(response.data.data);
    setValue(false);
  }
  function showPopupUpdate(id) {
    setIdCate(id);
    setEditmodalOpen(true);
  }
  function detailCate(category_id) {
    window.location.href= '/admin/course/detail/'+category_id;
  }
  async function deleteCate(category_id) {
    await axios
      .post(`${apiUrl}/admin/category/delete/${category_id}`)
      .then(async (response) => {
        toast(response.data.message);
        if (response.data.success) {
          setValue(true);
        }
      })
      .catch((error) => {
        if (error.response) {
          toast(error.response.data.message);
        } else {
          toast("Error");
        }
      });
  }
  useEffect(() => {
    fetchData();
  }, [value]);
  return (
    <>
      <div>
        <h2 className="page-header">Khóa học</h2>
        <div className="row">
          <div className="col-12">
            <div className="card">
              <div className="card_header">
                <div className="add-new-cate">
                  <button
                    onClick={() => {
                      setaddmodalOpen(!addmodalOpen);
                    }}
                  >
                    Thêm khóa học mới
                  </button>
                </div>
              </div>
              <div className="card__body">
                {categories ? (
                  <Table
                    headData={cateTableHead}
                    renderHead={(item, index) => renderHead(item, index)}
                    bodyData={categories}
                    renderBody={(item, index) => (
                      <Row
                        key={index}
                        item={item}
                        onEdit={showPopupUpdate}
                        onDelete={deleteCate}
                        onDetail={detailCate}
                      />
                    )}
                  />
                ) : (
                  <div className="w-100 text-center">
                    <div className="spinner-border text-dark" role="status"></div>
                  </div>
                )}
              </div>
            </div>
          </div>
        </div>
        <ToastContainer
          position="top-right"
          autoClose={2000}
          hideProgressBar={false}
          newestOnTop={false}
          closeOnClick
          rtl={false}
          pauseOnFocusLoss
          draggable
          pauseOnHover
        />
        {/* Same as */}
        <ToastContainer />
      </div>

      {addmodalOpen && (
        <AddcateModal setOpenModal={setaddmodalOpen} setValue={setValue} />
      )}
      {editmodalOpen && (
        <EditcateModal
          idCate={idCate}
          setOpenModal={setEditmodalOpen}
          setValue={setValue}
        />
      )}
    </>
  );
};

export default Category;
