from flask import Blueprint, render_template

welcome_bp = Blueprint('welcome', __name__, url_prefix='/')


@welcome_bp.route('/')
def index():
    return render_template('index.html')

