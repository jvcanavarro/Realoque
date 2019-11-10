"""
Base da API
"""

from flask import Flask, jsonify
from flask_cors import CORS
from sqlalchemy import create_engine
import pandas as pd

app = Flask(__name__)
CORS(app)

engine = create_engine('postgresql://equipe215:ZXF1aXBlMjE1QHNlcnBybw@bd.inova.serpro.gov.br:5432/equipe215')

with engine.connect() as connection:
    columns = connection.execute("SELECT column_name FROM information_schema.columns WHERE table_name='imoveis';")
    columns = columns.fetchall()
    columns = [column[0] for column in columns]

@app.route("/bairros")
def get_bairros():

    """
    Retorna os bairros com valores disponíveis
    :return:
    """
    with engine.connect() as connection:
        response = connection.execute("SELECT DISTINCT x.\"bairro\" FROM imoveis x ORDER BY x.\"bairro\";")

    connection.close()

    return jsonify([line[0] for line in response])

@app.route("/all")
def get_all():

    """
    Retorna todos
    :return:
    """
    with engine.connect() as connection:
        response = connection.execute(f"SELECT * FROM imoveis;").fetchall()
        response = [{columns[i]: line[i] for i in range(len(line))} for line in response]

    return jsonify(response)

@app.route("/bairro/<string:bairro>")
def getBy_bairro(bairro):

    """
    Retorna os imóveis disponíveis em determinado municipio
    :param str bairro:
    :return:
    """

    with engine.connect() as connection:
        response = connection.execute(f"SELECT x.* FROM imoveis x WHERE x.\"bairro\" = '{bairro}';").fetchall()
        response = [{columns[i]: line[i] for i in range(len(line))} for line in response]

    return jsonify(response)

@app.route("/valor/<int:valor>")
def getBy_valor(valor):

    """
    Retorna os imóveis disponíveis de acordo com o valor
    :param int valor:
    :return:
    """

    limite_inferior = valor * 0.2
    limite_superior = limite_inferior + .2

    with engine.connect() as connection:
        response = connection.execute(f"SELECT x.* FROM imoveis x WHERE x.\"normal_value_terreno\" <= {limite_superior} AND x.\"normal_value_terreno\" > {limite_inferior};").fetchall()
        response = [{columns[i]: line[i] for i in range(len(line))} for line in response]

    return jsonify(response)

if __name__ == "__main__":
    app.run(host = 'localhost', port = 7000, debug = False)
