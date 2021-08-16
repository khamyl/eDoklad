package sk.tuke.edoklad.classes;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import java.util.ArrayList;

import sk.tuke.edoklad.R;

public class FormAdapter extends BaseAdapter {
    private Context context;
    private ArrayList<Data> data;

    public FormAdapter(Context context, ArrayList<Data> data) {
        this.context = context;
        this.data = data;
    }

    @Override
    public int getCount() {
        return data.size();
    }

    @Override
    public Object getItem(int position) {
        return position;
    }

    @Override
    public long getItemId(int position) {
        return 0;
    }

    @Override
    public int getViewTypeCount() {
        return getCount();
    }

    @Override
    public int getItemViewType(int position) {
        return position;
    }

    public View getView(int position, View convertView, ViewGroup parent) {
        ViewHolder holder;

        if (convertView == null) {
            holder = new ViewHolder();
            LayoutInflater inflater = (LayoutInflater) context
                    .getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            convertView = inflater.inflate(R.layout.template, null, true);

            holder.txtPrevadzka = (TextView) convertView.findViewById(R.id.adapterPrevadzka);
            holder.txtDatum = (TextView) convertView.findViewById(R.id.adapterDatum);
            holder.txtSuma = (TextView) convertView.findViewById(R.id.adapterSuma);

            convertView.setTag(holder);
        }else {
            holder = (ViewHolder)convertView.getTag();
        }
        holder.txtPrevadzka.setText(data.get(position).getPrevadzka());
        holder.txtDatum.setText(data.get(position).getDatum());
        holder.txtSuma.setText(data.get(position).getAdresa());

        return convertView;
    }

    private class ViewHolder {
        TextView txtPrevadzka;
        TextView txtDatum;
        TextView txtSuma;
    }
}
