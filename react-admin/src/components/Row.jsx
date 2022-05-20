const Row = ({ item, value, onEdit = () => {}, onDelete, onDetail }) => {


  return (
    <tr>
      <td>{item.course_id}</td>
      <td>{item.name}</td>
      <td>{item.maximum_student}</td>
      <td>{item.amount_registed}</td>
      <td>
        <div className="cate-action">
          <div className="edit-action">
            <button onClick={()=>onEdit(item.id)}>
              <i className="bx bx-edit" style={{ fontSize: "20px",lineHeight: 1.5}} />
            </button>
            {/* {editmodalOpen ? <EditcateModal setOpenModal={seteditmodalOpen}/>:null}                                      */}
            <div className="modal-layout-edit"></div>
          </div>
          <div className="delete-action">
            <button onClick={()=>onDelete(item.id)}
                >
              <i className="bx bx-trash" style={{ fontSize: "20px",lineHeight: 1.5}} />
            </button>
          </div>
          <div className="edit-action" style={{ marginLeft: "10px"}}>
            <button onClick={()=>onDetail(item.course_id)}
                >
              <i className="bx bx-detail" style={{ fontSize: "20px",lineHeight: 1.5}} />
            </button>
          </div>
        </div>
      </td>
    </tr>
  );
};

export default Row;
