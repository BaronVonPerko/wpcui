import { Component } from "react";
import store, { actions } from "../redux/wpcuiReducer";
import { connect } from "react-redux";

export function modal(content) {
  store.dispatch({ type: actions.SHOW_MODAL, content });
}

export function hideModal() {
  store.dispatch({ type: actions.HIDE_MODAL });
}

interface IProps {
  content: Component;
}

class Modal extends Component<IProps, null> {
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
