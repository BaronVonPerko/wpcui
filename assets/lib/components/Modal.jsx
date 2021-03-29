import React from "react";
import store, { actions } from "../redux/wpcuiReducer";
import { connect } from "react-redux";

export function modal(content) {
  store.dispatch({ type: actions.SHOW_MODAL, content });
}

export function hideModal() {
  store.dispatch({ type: actions.HIDE_MODAL });
}

class Modal extends React.Component {
  render() {
    if (this.props.content) {
      return this.props.content;
    }
    return null;
  }
}

const mapStateToProps = (state) => ({
  content: state.modalContent,
});
export default connect(mapStateToProps)(Modal);
